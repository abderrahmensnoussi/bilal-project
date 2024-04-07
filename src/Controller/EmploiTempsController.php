<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\SessionRepository;
use App\Service\EmploiTempsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmploiTempsController extends AbstractController
{
    public function adminIndex(Request $request, SessionRepository $sessionRepository, EmploiTempsService $emploiTempsService): Response
    {
        $form = $this->createForm(SearchType::class, null, ['admin' => true]);
        $form->handleRequest($request);

        $criteria = [
            'dateDebut' => '',
            'dateFin' => '',
            'promotion' => '',
            'eleve' => '',
            'formateur' => ''
        ];

        $result = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = [
                'dateDebut' => $form->getData()['dateDebut'],
                'dateFin' => $form->getData()['dateFin'],
                'promotion' => ($form->getData()['promotion']) ? $form->getData()['promotion']->getId() : '',
                'eleve' => ($form->getData()['eleve'] !== null) ? $form->getData()['eleve']->getId() : '',
                'formateur' => ($form->getData()['formateur'] !== null) ? $form->getData()['formateur']->getId() : ''
            ];

            $sessions = $sessionRepository->findSessionBy($criteria);
            $result = $emploiTempsService->sessionToEmploiTemps($sessions);
        }

        return $this->render('emploi_temps/all/index.html.twig', [
            'title' => 'Emploi du Temps',
            'form' => $form,
            'dataArray' => $result,
            'criteria' => $criteria,
            'admin' => true,
        ]);
    }

    public function formateurIndex(Request $request, SessionRepository $sessionRepository, EmploiTempsService $emploiTempsService): Response
    {
        $form = $this->createForm(SearchType::class, null, ['admin' => false]);
        $form->handleRequest($request);

        $criteria = [
            'dateDebut' => '',
            'dateFin' => ''
        ];

        $result = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = [
                'dateDebut' => $form->getData()['dateDebut'],
                'dateFin' => $form->getData()['dateFin'],
                'promotion' => '',
                'eleve' => '',
                'formateur' => $this->getUser()->getId()
            ];

            $sessions = $sessionRepository->findSessionBy($criteria);
            $result = $emploiTempsService->sessionToEmploiTemps($sessions);
        }

        return $this->render('emploi_temps/all/index.html.twig', [
            'title' => 'Emploi du Temps',
            'form' => $form,
            'dataArray' => $result,
            'criteria' => $criteria,
            'admin' => false,
        ]);
    }

    public function eleveIndex(Request $request, SessionRepository $sessionRepository, EmploiTempsService $emploiTempsService): Response
    {
        $form = $this->createForm(SearchType::class, null, ['admin' => false]);
        $form->handleRequest($request);

        $criteria = [
            'dateDebut' => '',
            'dateFin' => ''
        ];

        $result = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = [
                'dateDebut' => $form->getData()['dateDebut'],
                'dateFin' => $form->getData()['dateFin'],
                'promotion' => '',
                'eleve' => $this->getUser()->getId(),
                'formateur' => ''
            ];

            $sessions = $sessionRepository->findSessionBy($criteria);
            $result = $emploiTempsService->sessionToEmploiTemps($sessions);
        }

        return $this->render('emploi_temps/all/index.html.twig', [
            'title' => 'Emploi du Temps',
            'form' => $form,
            'dataArray' => $result,
            'criteria' => $criteria,
            'admin' => false,
        ]);
    }
}
