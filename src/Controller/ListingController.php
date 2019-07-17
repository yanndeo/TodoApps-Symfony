<?php


namespace App\Controller;
use App\Entity\Listing;
use App\Repository\ListingRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/" , name="task_")
 */
class ListingController extends AbstractController
{



    /**
     * @Route("/" , name="allshow")
     */
    public function show(EntityManagerInterface $entityManager)
    {
        $listings = $entityManager->getRepository(Listing::class)->findAll();

       return $this->render('listing.html.twig', compact('listings'));

    }

    /**
     * @Route("/new", methods="POST" , name="create")
     */
    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $name = $request->get('name');

        if(empty($name)){

            $this->addFlash('warning', 'Le nom de la tâche doit être fournie.');

            return $this->redirectToRoute('task_allshow');
        }

        $listing = new Listing();
        $listing->setName($name);

            try{

                $entityManager->persist($listing);
                $entityManager->flush();

            }catch (UniqueConstraintViolationException $e){

                $this->addFlash('warning', 'Attention la tâche existe déjà!, impossible de l\'enregistrer à nouveau.');

            }


        $this->addFlash('success', 'la tâche' . $name . ' a été ajoutée.');

        return $this->redirectToRoute('task_allshow');

    }




}