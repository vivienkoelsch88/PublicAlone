<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Partie;
use App\Entity\Personnage;
use App\Form\PartieType;
use App\Form\SelectPartieType;
use App\Repository\PartieRepository;
use App\Repository\PersonnageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(){

        return $this->render('game/home.html.twig', [
            'Bienvenue' => 'Bienvenue sur Alone in the island',
            'Message' => ''
        ]);
    }

    /**
     * Affiche le début de la journée
     *
     * @Route("/debut/{id}", name="debutJournee")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function debutDeJournee(int $id){

        return $this->render('game/partie.html.twig', [
            'partieId' => $id
        ]);
    }

    /**
     * Affiche la liste des statistiques du joueur par le JS
     *
     * @Route("/partie/{id}/statPerso", name="statJoueur")
     * @param int $id
     * @param PersonnageRepository $personnageRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statJoueur(int $id, PersonnageRepository $personnageRepository) : Response{
        $personnage = $personnageRepository->findBy(array('Partie' => $id));
        $joueur = [$personnage[0]->getlife(), $personnage[0]->getMoral(), $personnage[0]->getNourriture()];


        return $this->json(['joueur' => $joueur], 200);
    }

    /**
     * Affiche un batiment par le JS
     *
     * @Route("/partie/{id}/{idBatiment}/statPerso", name="afficheBatiment")
     * @param int $id
     * @param PersonnageRepository $personnageRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function afficheBatiment(int $id, int $idBatiment, PersonnageRepository $personnageRepository) : Response{

        return $this->json(['idBatiment' => $idBatiment], 200);
    }

    /**
     * @Route("/jeu", name="jeu")
     * @param Request $request
     * @param ObjectManager $manager
     * @param PartieRepository $partieRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jeu(Request $request, ObjectManager $manager, PartieRepository $partieRepository){
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('game/home.html.twig', [
                'Bienvenue' => 'Bienvenue sur Alone in the island',
                'Message' => 'Il faut se connecter pour jouer'
            ]);
        } else {
            $parties = $partieRepository->findBy(array('User' => $user->getId()));

            $partie = new Partie($user);
            $form = $this->createForm(PartieType::class,$partie);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $camp = new Camp();
                $personnage = new Personnage($partie, $camp);
                $camp->setPersonnage($personnage);

                $partie->setPersonnage($personnage);

                $manager->persist($personnage);
                $manager->persist($camp);
                $manager->persist($partie);
                $manager->flush();

                return $this->redirectToRoute('jeu');
            }

            $formSelectPartie = $this->createForm(SelectPartieType::class);
            $formSelectPartie->handleRequest($request);

            if($formSelectPartie->isSubmitted() && $formSelectPartie->isValid()){

                $partieSelection = $request->request->get("partie");

                return $this->render('game/partie.html.twig', [
                    'partieId' => $partieSelection
                        ]);
            }

            return $this->render('game/jeu.html.twig', [
                'Bienvenue' => 'Bienvenue sur Alone in the island',
                'parties' => $parties,
                'form' => $form->createView(),
                'formSelectPartie' => $formSelectPartie->createView()
            ]);
        }
    }


}
