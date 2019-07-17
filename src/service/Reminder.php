<?php


namespace App\service;


use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class Reminder
{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;


    /**
     * Reminder constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }



    public function remind()
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findAll() ;

        

        return  7;

    }
}