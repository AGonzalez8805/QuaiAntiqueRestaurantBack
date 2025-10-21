<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Picture;
use App\Repository\PictureRepository;

#[Route('api/picture', name: 'app_api_picture_')]
class PictureController extends AbstractController
{
    private PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route(name: 'new_picture', methods: 'POST')]
    public function new(): Response
    {
        $picture = new Picture();
        $picture->settitle('plat de poisson');
        $picture->setslug('plat-de-poisson');
        $picture->setcreatedAt(new \DateTimeImmutable());
        $picture->setrestaurant(null);

        // A stocker en base

        return $this->json(
            ['message' => "Picture created with {$picture->getId()}"],
            Response::HTTP_CREATED
        );
    }

    #[Route('/show/{id}', name: 'show_picture', methods: 'GET')]
    public function show(int $id): Response
    {
        $picture = $this->repository->findOneBy(['id' => $id]);
        if (!$picture) {
            throw $this->createNotFoundException(
                'No picture found for id ' . $id
            );
        }

        return $this->json(
            ['message' => "Picture details : {$picture->getTitle()} for {$picture->getId()}"],
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'edit_picture', methods: 'PUT')]
    public function edit(int $id): Response
    {
        $picture = $this->repository->findOneBy(['id' => $id]);
        if (!$picture) {
            throw $this->createNotFoundException(
                "No picture found for {$id} id"
            );
        }

        // perform edit logic here (validate input, update entity, flush, etc.)

        return $this->redirectToRoute('app_api_picture_show', ['id' => $picture->getId()]);
    }

    #[Route('/{id}', name: 'delete_picture', methods: 'DELETE')]
    public function delete(int $id): Response
    {
        $picture = $this->repository->findOneBy(['id' => $id]);
        if (!$picture) {
            throw $this->createNotFoundException(
                'No picture found for id ' . $id
            );
        }

        // perform delete logic here (remove entity, flush, etc.)
        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
