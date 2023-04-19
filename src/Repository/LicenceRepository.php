<?php

namespace App\Repository;

use App\Entity\Licence;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Licence>
 *
 * @method Licence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licence[]    findAll()
 * @method Licence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Licence::class);
    }

    public function save(Licence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Licence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function licenceBateau(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Licence l , App\Entity\Categorie c
            Where l.relation  = :id AND l.codecategorie = c.id AND c.libelle = 'bateau'
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function licenceVoiture(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Licence l , App\Entity\Categorie c
            Where l.relation  = :id AND l.codecategorie = c.id AND c.libelle = 'voiture'
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function licenceCamion(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Licence l , App\Entity\Categorie c
            Where l.relation  = :id AND l.codecategorie = c.id AND c.libelle = 'camion'
            ")->setParameter('id', $id);

        return $res->getResult();
    }
    public function licenceMoto(int $id)
    {
        $conn = $this->getEntityManager();

        $res = $conn->createQuery( "
            SELECT count(l.id)
            FROM App\Entity\Licence l , App\Entity\Categorie c
            Where l.relation  = :id AND l.codecategorie = c.id AND c.libelle = 'moto'
            ")->setParameter('id', $id);

        return $res->getResult();
    }

//    /**
//     * @return Licence[] Returns an array of Licence objects
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

//    public function findOneBySomeField($value): ?Licence
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
