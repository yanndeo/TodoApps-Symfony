<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListingRepository")
 */
class Listing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $name;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task" , mappedBy="listing" , cascade= {"remove"} )
     *
     */
    private $tasks;

    /**
     * @return mixed
     */
    public function getTasks()
    {
        return $this->tasks;
    }






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
}
