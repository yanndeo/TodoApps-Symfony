<?php


namespace App\Controller;
use App\Entity\Listing;
use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
 */
class ListingController extends AbstractController
{


    public function __construct()
    {

    }

    /**
     * @Route("/")
     */
    public function show(EntityManagerInterface $entityManager)
    {
        $listings = $entityManager->getRepository(Listing::class)->findAll();

       return $this->render('listing.html.twig', compact('listings'));

    }

}