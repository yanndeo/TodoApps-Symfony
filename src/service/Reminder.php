<?php


namespace App\service;


use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class Reminder
{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    protected $twig;

    protected $mailer;


    /**
     * Reminder constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager,  Environment $twig,  \Swift_Mailer $mailer)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;

        $this->mailer =$mailer;

    }



    public function remind()
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findAllToRemind(new \DateTime())  ;

        /*foreach ($tasks as $task){

            $message = (new \Swift_Message( "Une tâche doit être réaliser"))
                        ->setFrom('admin@example.com')
                        ->setTo('yanndeo@example.com')
                        ->setBody(
                            $this->renderView(
                                'emails/reminder.html.twig',
                                ['task' => $task]

                            ),
                            'text/html'
                        )

                ->addPart(
                    $this->renderView(
                        'emails/reminder.txt.twig',
                        ['task' => $task]
                    ),
                    'text/plain'
                );

            $this->mailer->send($message);

            $task->setReminderDone(true);

        }

        $this->entityManager->flush();*/

        return sizeof($tasks);

    }
}