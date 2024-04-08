<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Emarger;
use App\Form\EmargementCollectionType;
use App\Form\EmargerEleveType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmargementController extends AbstractController
{

    public function emargementEdit(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($session->getFormateur() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        foreach ($session->getPromotion()->getInscriptions() as $inscription) {
            $checkEmarger = $entityManager->getRepository(Emarger::class)->findOneBy(['utilisateur' => $inscription->getEleve(), 'session' => $session]);
            if ($checkEmarger === null) {
                $emarger = new Emarger();
                $emarger->setSession($session);
                $emarger->setUtilisateur($inscription->getEleve());
                $entityManager->persist($emarger);
                $entityManager->flush();
            }
        }

        $form = $this->createForm(EmargementCollectionType::class, ['emargers' => $session->getEmargers()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData()['emargers'] as $emarger) {
                if ($emarger->isPresence() === null) {
                    $emarger->setAlternative(null);
                    $emarger->setHeureArrive(null);
                    $emarger->setHeureDepart(null);
                    $emarger->setSignature(false);
                } else {
                    $emarger->setSignature(true);
                }
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_emargement_show', ['id' => $session->getId()]);
        }

        return $this->render('emargement/edit.html.twig', [
            'title' => 'Emargement',
            'session' => $session,
            'form' => $form,
        ]);
    }

    public function emargementShow(Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getRoles()[0] === 'ROLE_FORMATEUR' && $session->getFormateur() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        foreach ($session->getPromotion()->getInscriptions() as $inscription) {
            $checkEmarger = $entityManager->getRepository(Emarger::class)->findOneBy(['utilisateur' => $inscription->getEleve(), 'session' => $session]);
            if ($checkEmarger === null) {
                $emarger = new Emarger();
                $emarger->setSession($session);
                $emarger->setUtilisateur($inscription->getEleve());
                $entityManager->persist($emarger);
                $entityManager->flush();
            }
        }

        return $this->render('emargement/show.html.twig', [
            'title' => 'Emargements',
            'session' => $session,
            'emargements' => $session->getEmargers(),
        ]);
    }

    public function emargementEleve(EntityManagerInterface $entityManager): Response
    {
        $emargements = $entityManager->getRepository(Emarger::class)->findBy(['utilisateur' => $this->getUser()]);

        return $this->render('emargement/eleve.html.twig', [
            'title' => 'Emargements',
            'emargements' => $emargements,
        ]);
    }

    public function emargerEleve(Request $request, Emarger $emarger, EntityManagerInterface $entityManager): Response
    {
        if ($emarger->getUtilisateur() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(EmargerEleveType::class, $emarger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($emarger->isPresence() === null) {
                $emarger->setAlternative(null);
                $emarger->setHeureArrive(null);
                $emarger->setHeureDepart(null);
                $emarger->setSignature(false);
            } else {
                $emarger->setSignature(true);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_emargement_eleve');
        }

        return $this->render('emargement/emarger_eleve.html.twig', [
            'title' => 'Emarger',
            'session' => $emarger->getSession(),
            'form' => $form,
        ]);
    }
}
