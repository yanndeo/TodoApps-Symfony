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









    /**
     * @Route("/{taskID}/edit", name="edit", requirements={"taskID"= "\d+" })
     */
    public function edit(EntityManagerInterface $entityManager,  Request $request , $listingID, $taskID )
    {

        $listing = $entityManager->getRepository(Listing::class)->find($listingID); //Asssurns nous juste que l'ID de la liste est bien existe vraiment


        if(empty($listing)){

            $this->addFlash('danger' , 'Le listing associer à cette tâche n\'existe pas . ');

        }

        $task = $entityManager->getRepository(Task::class)->find($taskID);

        if(empty($task)){

            $this->addFlash('warning' , 'La tâche indiquée n\'existe pas');

            return $this->redirectToRoute('listing_show', ['listingID'=> $listingID]);

        }



        $form= $this->createForm(TaskType::class, $task );

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {

            $entityManager->flush();

            $this->addFlash('succcess' , 'La tâche << '. $task->getName() . '>> a été modifée');

            return $this->redirectToRoute('listing_show', ['listingID'=> $listingID]);
        }



        return $this->render('task.html.twig', ['form'=> $form->createView()] );

    }


    /**
     * @Route("/{taskID}/delete", name="delete", requirements= {"taskID"="\d+"})
     */
    public function delete(EntityManagerInterface $entityManager, $listingID, $taskID)
    {

        $task = $entityManager->getRepository(Task::class)->find($taskID);

        if(empty($task)){

            $this->addFlash('danger', 'La tâche indiquée n\' existe pas!!!');


        }else{
            $entityManager->remove($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche <<' . $task->getName() . '>>  a bien été supprimée');
        }



        return $this->redirectToRoute('listing_show', ['listingID'=> $listingID]);

    }



    //PS: $listingID nous es passé pas la route principale definie dans la class.
}