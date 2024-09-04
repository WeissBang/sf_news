<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/articles', name: 'api_articles_list', methods: ['GET'])]
    public function articlesList(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->json($articles, context: [
            'groups' => ['articles_read']
        ]);
    }

    #[Route('/categories', name: 'api_categories_list', methods: ['GET'])]
    public function categoriesList(CategoryRepository $categoryRepository): Response
    {
        return $this->json(
            $categoryRepository->findAll(),
            context: [
                'groups' => ['categories_read']
            ]
        );
    }
}
