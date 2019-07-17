<?php


namespace App\Controller;
use App\Entity\Listing;
use App\Repository\ListingRepository;
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
     * @Route("/")
     */
    public function show(EntityManagerInterface $entityManager)
    {
        $listings = $entityManager->getRepository(Listing::class)->findAll();

       return $this->render('listing.html.twig', compact('listings'));

    }

    /**
     * @Route("/new", methods="POST" , name="create")
     */
    public function create(EntityManagerInterface $entityManager, Request $request):Response
    {

        $name = $request->get('name');
        //var_dump($name); die();

        $listing = new Listing();
        $listing->setName($name);

        $entityManager->persist($listing);
        $entityManager->flush();

        return new Response('ok');

    }




}