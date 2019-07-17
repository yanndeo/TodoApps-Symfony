<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dueDate;



    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(
     *     min= 5,
     *     max= 300,
     *     minMessage ="Vous devez configurer le rappel au moins 5 minutes avant la date d'écheance de la tâche",
     *     maxMessage ="Vous devez configurer le rappel au plus 300 minutes avant la date d'écheance de la tâche"
     * )
     */
    private $reminder;




    /**
     * @ORM\Column(type="boolean")
     */
    private $reminderDone =false;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Listing", inversedBy="tasks")
     * @ORM\JoinColumn()
     */
    private $listing;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param mixed $dueDate
     */
    public function setDueDate($dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return mixed
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * @param mixed $reminder
     */
    public function setReminder($reminder): void
    {
        $this->reminder = $reminder;
    }

    /**
     * @return mixed
     */
    public function isReminderDone()
    {
        return $this->reminderDone;
    }

    /**
     * @param mixed $reminderDone
     */
    public function setReminderDone($reminderDone): void
    {
        $this->reminderDone = $reminderDone;
    }










    /**
     * @return mixed
     */
    public function getListing()
    {
        return $this->listing;
    }

    /**
     * @param mixed $listing
     */
    public function setListing(Listing $listing): void
    {
        $this->listing = $listing;
    }

}
