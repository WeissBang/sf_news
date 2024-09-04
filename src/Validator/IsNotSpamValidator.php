<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IsNotSpamValidator extends ConstraintValidator
{
    public function __construct(
        private HttpClientInterface $spamChecker
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        $response = $this->spamChecker->request(
            Request::METHOD_POST,
            "/api/check",
            [
                'json' => ['email' => $value]
            ]
        );

        $data = $response->toArray();
        $isSpam = $data['result'] === 'spam';

        if (!$isSpam) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
