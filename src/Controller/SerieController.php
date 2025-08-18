<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class  SerieController extends AbstractController
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
    #[Route('/serie/{page}', name: 'app_serie',requirements: ['page' => '\d+'], defaults: ['page'=>1],methods: ['GET'])]
    public function list(SerieRepository $serieRepository,int $page,ParameterBagInterface $parameters): Response
    {
        //$serie = $serieRepository->findAll();
        //dd($serie);
        //return $this->render('serie/list.html.twig', ['series' => $serie]);
        $nbPerPage = $parameters->get('serie')['nb_max'];
        $offset = ($page-1)*$nbPerPage;

        $criterias =            [
            'status' => 'Returning',
            'genres' => 'Comedy'
        ];
        $series = $serieRepository->findBy(
            $criterias,
            ['popularity' => 'DESC'],
            $nbPerPage,
            $offset

            );

            $total = $serieRepository->count($criterias);
            $totalPages = ceil($total/$nbPerPage);
        return $this->render('serie/list.html.twig', [
                'series'=>$series,
                'page'=>$page,
                'totalPages'=>$totalPages,
            ]
        );
    }

    #[Route('/liste-custom',name: '_custom-list')]
    public function listCustom(SerieRepository $serie): Response
    {
        return $this->render('serie/list.html.twig',[
            'page'=>10,
            'totalPages'=>10,
        ]);
    }


}
