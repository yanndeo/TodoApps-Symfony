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



    private $em;

    private $taskRepository;

    private $listingRepository;


    /**
     * TaskController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

        $this->taskRepository = $this->em->getRepository(Task::class);

        $this->listingRepository = $this->em->getRepository(Listing::class);


    }




    /**
     * @Route("/new", name="create")
     */
    public function create(Request $request , $listingID)
    {
        //Récupérant le listing en cours afin d'y associer la nouvelle task à ce listing.
        //On repond à la question de savoir  : Dans quelle listing la tâche sera telle creer.

        $listing = $this->listingRepository->find($listingID);


        $task = new Task();

        $task->setListing($listing);

        $form= $this->createForm(TaskType::class, $task );

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
            $this->em ->persist($task);

            $this->em->flush();

            $this->addFlash('success' , 'La tâche indiquée <<' . $task->getName() .' >> a été ajoutée dans la liste ' . $listing->getName() );

            return $this->redirectToRoute('listing_show', ['listingID'=> $listingID]);
        }

        return $this->render('task.html.twig', ['form'=> $form->createView()] );

    }









    /**
     * @Route("/{taskID}/edit", name="edit", requirements={"taskID"= "\d+" })
     */
    public function edit(Request $request , $listingID, $taskID )
    {

        $listing = $this->listingRepository->find($listingID);   //Asssurons nous juste que l'ID de la liste est bien existe vraiment

        if(empty($listing)){

            $this->addFlash('danger' , 'Le listing associer à cette tâche n\'existe pas . ');
        }


        $task = $this->taskRepository->find($taskID);

        if(empty($task)){

            $this->addFlash('warning' , 'La tâche indiquée n\'existe pas');

            return $this->redirectToRoute('listing_show', ['listingID'=> $listingID]);
        }


        $form= $this->createForm(TaskType::class, $task );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->em->flush();

            $this->addFlash('succcess' , 'La tâche << '. $task->getName() . '>> a été modifée');

            return $this->redirectToRoute('listing_show', ['listingID'=> $listingID]);
        }


        return $this->render('task.html.twig', ['form' => $form->createView()] );

    }








    /**
     * @Route("/{taskID}/delete", name="delete", requirements= {"taskID"="\d+"})
     */
    public function delete($listingID, $taskID)
    {

        $task = $this->taskRepository->find($taskID);

        if(empty($task)){

            $this->addFlash('danger', 'La tâche indiquée n\' existe pas!!!');

        }else{

            $this->em->remove($task);

            $this->em->flush();

            $this->addFlash('success', 'La tâche <<' . $task->getName() . '>>  a bien été supprimée');
        }


        return $this->redirectToRoute('listing_show', ['listingID'=> $listingID]);

    }



    //PS: $listingID nous est passé pas la route principale definie dans la class.
}