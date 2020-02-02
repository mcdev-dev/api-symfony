<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/article", name="article_create")
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function createAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $data = $request->getContent();
        $article = $serializer->deserialize($data, 'App\Entity\Article', 'json');
        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('', Response::HTTP_CREATED);

    }


    /**
     * @Route("/articles/{id}", name="article_show")
     * @param SerializerInterface $serializer
     * @param Article $article
     * @return Response
     */
    public function showAction(SerializerInterface $serializer, Article $article)
    {
        $data = $serializer->serialize($article, 'json', SerializationContext::create()->setGroups(['details']));
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @Route("/liste/articles", name="article_list")
     * @param SerializerInterface $serializer
     * @param ArticleRepository $repository
     * @return Response
     */
    public function listAction(SerializerInterface $serializer, ArticleRepository $repository)
    {
        $articles = $repository->findAll();

        $data = $serializer->serialize($articles, 'json', SerializationContext::create()->setGroups(['list']));
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
