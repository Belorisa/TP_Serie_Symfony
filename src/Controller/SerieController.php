<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SerieController extends AbstractController
{
//    #[Route('/serie', name: 'app_serie')]
//    public function index(EntityManagerInterface $em): Response
//    {
//        $serie = new Serie();
//        $serie->setName("One Piece")
//            ->setStatus('Returning')
//            ->setGenres('Animé')
//            ->setFirstAirDate(new \DateTime('1999-10-20'))
//            ->setDateCreated(new \DateTime());
//
//        $em->persist($serie);
//        $em->flush();
//
//       return new Response('Une série a été créée');
//    }
    #[Route('/serie', name: 'app_serie')]
    public function list(SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->findAll();
        //dd($serie);
        return $this->render('serie/list.html.twig', ['series' => $serie]);
    }
}
