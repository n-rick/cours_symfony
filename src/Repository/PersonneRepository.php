<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Personne $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Personne $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    //    /**
    //     * @return Personne[] Returns an array of Personne objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    // /**
    //  * @return Personne[] Returns an array of Personne objects
    //  */
    // public function findByNomAndPrenom(string $nom, string $prenom): array
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.nom = :nom')
    //         ->setParameter('nom', $nom)
    //         ->andWhere('p.prenom = :prenom')
    //         ->setParameter('prenom', $prenom)
    //         ->orderBy('p.id', 'ASC')
    //         ->getQuery()
    //         ->getResult();
    // }

    // /**
    //  * Avec une recherche par initiale
    //  * @return Personne[] Returns an array of Personne objects
    //  */
    // public function findByNomAndPrenom(string $nom, string $prenom): array
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.nom LIKE :nom')
    //         ->setParameter('nom', '%' . $nom . '%')
    //         ->andWhere('p.prenom LIKE :prenom')
    //         ->setParameter('prenom', '%' . $prenom . '%')
    //         ->orderBy('p.id', 'ASC')
    //         ->getQuery()
    //         ->getResult();
    // }

    // /**
    //  * Avec une recherche par nom et prenom avec createQuery (DQL)
    //  * @return Personne[] Returns an array of Personne objects
    //  */
    // public function findByNomAndPrenom(string $nom, string $prenom): array
    // {
    //     $query = $this->_em->createQuery(
    //         'SELECT p
    //         FROM App\Entity\Personne p
    //         WHERE p.nom = :nom
    //         and p.prenom = :prenom'
    //     )->setParameter('nom', $nom)
    //         ->setParameter('prenom', $prenom);
    //     $result = $query->getResult();
    //     return $result;
    // }

    // /**
    //  * Avec une recherche par initiale avec createQuery (DQL)
    //  * @return Personne[] Returns an array of Personne objects
    //  */
    // public function findByNomAndPrenom(string $nom, string $prenom): array
    // {
    //     $query = $this->_em->createQuery(
    //         'SELECT p
    //         FROM App\Entity\Personne p
    //         WHERE p.nom LIKE :nom
    //         and p.prenom LIKE :prenom'
    //     )->setParameter('nom', "%$nom%")
    //         ->setParameter('prenom', "%$prenom%");
    //     $result = $query->getResult();
    //     return $result;
    // }

    /**
     * Avec une recherche par initiale avec createQuery (SQL)
     */
    public function findByNomAndPrenom(string $nom, string $prenom)
    {
        $query = $this->_em->getConnection()->prepare(
            'SELECT p
            FROM App\Entity\Personne p
            WHERE p.nom LIKE :nom
            and p.prenom LIKE :prenom'
        );
        $result = $query->executeQuery([
            'nom' => $nom,
            'prenom' => $prenom,
        ]);
        return $result->fetchAllAssociative();
    }

    /**
     * Avec une recherche par initiale avec createQuery (DQL)
     * @return Personne[] Returns an array of Personne objects
     */
    public function findByOnlyPersonnes()
    {
        return $this->createQueryBuilder('p')
            ->where('p not instance of App\Entity\Etudiant')
            ->andWhere('p not instance of App\Entity\Enseignant')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Personne
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
