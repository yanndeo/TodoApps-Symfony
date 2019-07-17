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



    /**
     * @Route("/{listingID}" , name="show" , requirements={"listingID"="\d+" })
     */
    public function show(EntityManagerInterface $entityManager , $listingID = null)
    {
        $listings = $entityManager->getRepository(Listing::class)->findAll();

        if(!empty($listingID)){
           $currentListing=  $entityManager->getRepository(Listing::class)->find($listingID);
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
        $entityManager = $this->getDoctrine()->getManager();

        $name = $request->get('name');

        if(empty($name)){

            $this->addFlash('warning', 'Le nom de la tâche doit être fournie.');

            return $this->redirectToRoute('listing_show');
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

        return $this->redirectToRoute('listing_show');

    }








    /**
     * @Route("/{listingID}/delete", name="delete"  , requirements={"listingID" ="\d+"})
     */
    public function delete(Listing $listingID)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $listing= $entityManager->getRepository(Listing::class)->find($listingID);


        if(!$listing){
            $this->addFlash('danger', 'Tâche non trouvée .');

        }else{
            $entityManager->remove(($listing));
            $entityManager->flush();
            $this->addFlash('danger', 'La tâche <<'. $listing->getName() . ' >> a été supprimée');

        }

        return $this->redirectToRoute('listing_show');




    }










}