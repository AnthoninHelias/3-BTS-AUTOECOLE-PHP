<?php

namespace App\Repository;

use App\Entity\Lecon;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lecon>
 *
 * @method Lecon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lecon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lecon[]    findAll()
 * @method Lecon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeconRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lecon::class);
    }

    public function save(Lecon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Lecon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByUser(int $id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT u
            FROM App\Entity\User u
            WHERE u.id = :id
            "
        );
        $query->setParameter('id',$id);

        return $query->getResult();
    }

    public function leconOfUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT l.id , l.date , l.heure , l.reglee
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }

    public function leconPayee(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE l.reglee = 1 AND lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function leconNonPayee(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE l.reglee = 0 AND lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function leconFaites(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE l.date < '2023-04-19'  AND lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function leconNonFaites(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE l.date > '2023-04-19' AND lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function lecondujour(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE l.date = '2023-04-19'  AND lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function lecondelasemaine(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE l.date BETWEEN '2023-04-19' AND '2023-04-12' AND lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function lecondumois(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE l.date BETWEEN '2023-04-19' AND '2023-03-19'  AND lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function lecondelanne(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE l.date BETWEEN '2023-04-19' AND '2022-04-19'  AND lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function leconTotal(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l 
            JOIN  l.relation lu
            WHERE lu.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }


    public function nombreLeconVoitureJourUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(u.id)
            FROM App\Entity\Lecon l ,  App\Entity\Vehicule v  ,  App\Entity\Categorie c , App\Entity\User u
            Where  l.immatriculation = v.id AND l.date = '2023-04-19' AND v.idcategorie = c.id AND c.libelle = 'voiture' AND u.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function nombreLeconMotoJourUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(u.id)
            FROM App\Entity\Lecon l ,  App\Entity\Vehicule v  ,  App\Entity\Categorie c , App\Entity\User u
            Where  l.immatriculation = v.id AND l.date = '2023-04-19' AND v.idcategorie = c.id AND c.libelle = 'moto' AND u.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function nombreLeconBateauJourUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(u.id)
            FROM App\Entity\Lecon l ,  App\Entity\Vehicule v  ,  App\Entity\Categorie c , App\Entity\User u
            Where  l.immatriculation = v.id AND l.date = '2023-04-19' AND v.idcategorie = c.id AND c.libelle = 'bateau' AND u.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function nombreLeconCamionJourUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(u.id)
            FROM App\Entity\Lecon l ,  App\Entity\Vehicule v  ,  App\Entity\Categorie c , App\Entity\User u
            Where  l.immatriculation = v.id AND l.date = '2023-04-19' AND v.idcategorie = c.id AND c.libelle = 'camion' AND u.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }


    public function nombreLeconVoitureSemaineUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(u.id)
            FROM App\Entity\Lecon l ,  App\Entity\Vehicule v  ,  App\Entity\Categorie c , App\Entity\User u
            Where  l.immatriculation = v.id AND l.date BETWEEN '2023-04-19' AND '2023-04-12' AND v.idcategorie = c.id AND c.libelle = 'voiture' AND u.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function nombreLeconMotoSemaineUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(u.id)
            FROM App\Entity\Lecon l ,  App\Entity\Vehicule v  ,  App\Entity\Categorie c , App\Entity\User u
            Where  l.immatriculation = v.id AND l.date BETWEEN '2023-04-19' AND '2023-04-12' AND v.idcategorie = c.id AND c.libelle = 'moto' AND u.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function nombreLeconBateauSemaineUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(u.id)
            FROM App\Entity\Lecon l ,  App\Entity\Vehicule v  ,  App\Entity\Categorie c , App\Entity\User u
            Where  l.immatriculation = v.id AND l.date BETWEEN '2023-04-19' AND '2023-04-12' AND v.idcategorie = c.id AND c.libelle = 'bateau' AND u.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function nombreLeconCamionSemaineUser(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(u.id)
            FROM App\Entity\Lecon l ,  App\Entity\Vehicule v  ,  App\Entity\Categorie c , App\Entity\User u
            Where  l.immatriculation = v.id AND l.date BETWEEN '2023-04-19' AND '2023-04-12' AND v.idcategorie = c.id AND c.libelle = 'camion' AND u.id = :id
            ")->setParameter('id', $id);

        return $res->getResult();
    }



    public function montantLeconAPayer(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Lecon l , App\Entity\Categorie c , App\Entity\Vehicule v
            JOIN  l.relation lu
            JOIN  l.immatriculation lm
            JOIN  v.idcategorie idc
            WHERE l.reglee = 1 AND lu.id = :id AND c.codecategorie= 1
            ")->setParameter('id', $id);

        return $res->getResult();
    }

//    /**
//     * @return Lecon[] Returns an array of Lecon objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Lecon
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
