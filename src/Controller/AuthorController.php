<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AuthorController extends AbstractController
{

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @Route("/authors", name="author_create")
     * @return Response
     */
    public function createAction(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $author = $serializer->deserialize($data, 'App\Entity\Author', 'json');
        $entityManager->persist($author);
        $entityManager->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/author/{id}", name="author_show")
     * @param SerializerInterface $serializer
     * @param Author $author
     * @return Response
     */
    public function showAction(SerializerInterface $serializer, Author $author)
    {
        $data = $serializer->serialize($author, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'Application/json');

        return $response;
    }


}
