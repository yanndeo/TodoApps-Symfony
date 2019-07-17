<?php


namespace App\Controller;


use App\Entity\Listing;
use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("{listingID}/task", name="task_", requirements={"listingID"= "\d+" })
 * Class TaskController
 * @package App\Controller
 */
class TaskController extends AbstractController
{



    /**
     * @Route("/new", name="create")
     */
    public function create(EntityManagerInterface $entityManager,  Request $request , $listingID)
    {
        /**
         * Récupérant le listing en cours afin d'y associer la nouvelle task à ce listing.
         * On repond à la question de savoir  : Dans quelle listing la tâche sera telle creer.
         */

        $listing = $entityManager->getRepository(Listing::class)->find($listingID);


        $task = new Task();

        $task->setListing($listing);

        $form= $this->createForm(TaskType::class, $task );

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($task);

            $entityManager->flush();

            return $this->redirectToRoute('listing_show', ['listingID'=> $listingID]);
        }

        return $this->render('task.html.twig', ['form'=> $form->createView()] );

    }


}