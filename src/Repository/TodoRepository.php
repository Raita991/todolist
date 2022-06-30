<?php

namespace App\Repository;

use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Todo>
 *
 * @method Todo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todo[]    findAll()
 * @method Todo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todo::class);
    }

    public function add(Todo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Todo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findTask(int $task)
    {
        $conn = $this->getEntityManager()->getConnection();

        if ($task > 2) {
            $sql = '
                SELECT * FROM todo t
            ';
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();

            return $resultSet->fetchAllAssociative();
        }
    }

    public function DeleteTask(int $result)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            DELETE i
            FROM App\Entity\Todo i
            WHERE i.id = id'
        )->setParameter(
            'id',
            $result,
        );
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        return void;
        ;
    }
    /*public function findTask(string $task) : array
    {
        return $this->createQueryBuilder('t')
        ->andWhere('t.task = :task')
        ->setParameter('task', $task)
        ->getQuery()
        ->getResult()
        ;
    }*/

//    /**
//     * @return Todo[] Returns an array of Todo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Todo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
