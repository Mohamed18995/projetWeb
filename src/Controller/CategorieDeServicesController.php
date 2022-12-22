<?php

namespace App\Controller;

use App\Entity\CategorieDeServices;
use App\Form\CategorieDeServicesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class CategorieDeServicesController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie_de_services/index.html.twig', [
            'current_menu' => 'categorie'
        ]);
    }

    //afficher des categories
    #[Route('/categorie', name: 'app_categorie')]
    public function categ(EntityManagerInterface $entityManager): Response
    {

      $categories = $entityManager->getRepository(CategorieDeServices::class)->findAll();


        return $this->render('categorie_de_services/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    //afficher une categorie

    /**
    * @Route("/categorie/{id}", name="afficher_categorie")
    */
    // public function afficher($id, EntityManagerInterface $entityManager) : Response
    // {
    //   $repository = $entityManager->getRepository(Chanson::class);
    //   $chansons = $repository->findBy(["categorie" => $id]);

    //   return $this->render('home/index.html.twig', [
    //    'chansons' => $chansons,
    //    ]);
    // }

     /**
   * @Route("/create/categorie", name="categorie_create")
   */
  public function add(Request $request, PersistenceManagerRegistry $doctrine) 
  {
    $categorie = new CategorieDeServices();
    $form = $this->createForm(CategorieDeServicesType::class, $categorie);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $categorie = $form->getData();
      $entityManager = $doctrine->getManager();
      $entityManager->persist($categorie);
      $entityManager->flush();

      return $this->redirectToRoute('categoriedeservices');

    }
    return $this->render('categorie_de_services/AddCateg.html.twig', ['form' =>$form->createView()]);
  }
}
