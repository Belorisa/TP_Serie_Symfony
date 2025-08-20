<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Serie;
use App\Form\SeasonType;
use App\Form\SerieType;
use Doctrine\ORM\EntityManagerInterface;
use Dom\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class SeasonController extends AbstractController
{
    #[Route('/season/create', name: 'season_create')]
    public function create(Request $request,EntityManagerInterface $em): Response
    {
        $season = new Season();

        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $em->persist($season);
            $em->flush();

            $this->addFlash('success', 'Une nouvelle saison a été rée');
            return $this->redirectToRoute('detail',['id'=>$season->getSerie()->getId()]);
        }

        return $this->render('season/edit.html.twig', [
            'season_form' => $form,
        ]);
    }

    #[Route('/serie/update/{id}',name: 'serie_update')]
    public function editSerie(Season $season,Request $request,EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SeasonType::class, $season);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //dd($serie);
            $em->persist($season);
            $em->flush();

            $this->addFlash("success",'une sérié a été enregistrée');

            return $this->redirectToRoute('detail',['id'=>$season->getSerie()->getId()]);
        }
        return $this->render('season/edit.html.twig',[
            'serie_form' => $form,
        ]);
    }

}
