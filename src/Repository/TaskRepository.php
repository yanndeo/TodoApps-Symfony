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


    public function findAllToRemindeee(\DateTime $datetime)
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





    public function findAllToRemind(\DateTime $dateTime)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM task t 
            WHERE t.reminder_done = :reminder_done  
            AND t.done = :done 
            AND SUBTIME(t.due_date ,CONCAT(\'0:\' ,t.reminder, \':0\') ) <= :datetime
            ORDER BY t.due_date DESC 
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'reminder_done' => false,
            'done'=> false,
            'datetime'=> $dateTime->format(\DateTime::ISO8601)
        ]);


        return $stmt->fetchAll();
    }



    //Recupere les tasks dont la date de rappel (t.due_date) a laquelle on soustrait le nombre de minutes preciser(t.reminder)
    //dont le resulat de cette soustration est inferieur à la date actuelle
    //A condition qu'elle ne soit pas dejà achevée
    //et qu'elle n'est pas dejà été rappélé à lutilsater(reminder_done =0)


}
