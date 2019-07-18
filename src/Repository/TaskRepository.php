<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }


    public function findAllToRemind(\DateTime $datetime)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.reminderDone = false')
            ->andWhere('SUBTIME(t.dueDate, CONCAT(\'0:\' ,t.reminder, \':0\')) <= :datetime')
            ->setParameter('datetime', $datetime)
            ->orderBy('t.dueDate', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }



}
