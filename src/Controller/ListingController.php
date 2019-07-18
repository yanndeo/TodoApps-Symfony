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
 * @Route("/" , name="listing_")
 */
class ListingController extends AbstractController
{

    private $em;

    private $listingRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

        $this->listingRepository = $this->em->getRepository(Listing::class);
    }




    /**
     * @Route("/{listingID}" , name="show" , requirements={"listingID"="\d+" })
     */
    public function show( $listingID = null)
    {
        $listings = $this->listingRepository->findAll();

        if(!empty($listingID)){
            $currentListing = $this->listingRepository->find($listingID);
        }

        if(empty($currentListing)){
            $currentListing = current($listings);
        }


       return $this->render('listing.html.twig', compact('listings', 'currentListing'));

    }









    /**
     * @Route("/new", methods="POST" , name="create")
     */
    public function create(Request $request)
    {

        $name = $request->get('name');  //Reccuperont l'information dans la request

        if(empty($name)){

            $this->addFlash('warning', 'Le nom de la tâche doit être fournie.');

        }else{

            $listing = new Listing();

            $listing->setName($name);

            //Gestion d'erreur sql

            try{

                $this->em->persist($listing);

                $this->em->flush();

                $this->addFlash('success', 'la tâche ' . $name . ' a été ajoutée.');

            }catch (UniqueConstraintViolationException $e){

                $this->addFlash('warning', 'Attention la tâche existe déjà!, impossible de l\'enregistrer à nouveau.');
            }

        }

        return $this->redirectToRoute('listing_show');

    }








    /**
     * @Route("/{listingID}/delete", name="delete"  , requirements={"listingID" ="\d+"})
     */
    public function delete(Listing $listingID)
    {

        $listing = $this->listingRepository->find($listingID);

        if(!$listing){

            $this->addFlash('danger', 'Tâche non trouvée .');

        }else{

            $this->em->remove(($listing));

            $this->em->flush();

            $this->addFlash('danger', 'La tâche <<'. $listing->getName() . ' >> a été supprimée');

        }

        return $this->redirectToRoute('listing_show');




    }










}