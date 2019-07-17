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
     * @Route("/{taskID}" , name="show" , requirements={"taskID"="\d+" })
     */
    public function show(EntityManagerInterface $entityManager , $taskID = null)
    {
        $listings = $entityManager->getRepository(Listing::class)->findAll();

        if(!empty($taskID)){
           $currentTask=  $entityManager->getRepository(Listing::class)->find($taskID);
        }
        if(empty($currentTask)){
            $currentTask = current($listings);
        }



       return $this->render('listing.html.twig', compact('listings', 'currentTask'));

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

            return $this->redirectToRoute('task_show');
        }

        $listing = new Listing();
        $listing->setName($name);

            try{

                $entityManager->persist($listing);
                $entityManager->flush();

            }catch (UniqueConstraintViolationException $e){

                $this->addFlash('warning', 'Attention la tâche existe déjà!, impossible de l\'enregistrer à nouveau.');

            }


        $this->addFlash('success', 'la tâche ' . $name . ' a été ajoutée.');

        return $this->redirectToRoute('task_show');

    }










}