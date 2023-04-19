<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Select;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Exception\StringCastException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    public function eleve()
    {

        $query = $this->getEntityManager()->createQuery
        (
        /* requete a inserer ici
        from lecon l //ici l est un alias de lecon
    */);
        // le getOneOrNullResult retourne un rÃ©sultat unique (pas d'array)
        return $query->getOneOrNullResult();

    }

    public function getNomMoniteur()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT nom
            FROM user u
            WHERE u.roles LIKE "%ROLE_MONITEUR%"
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet;
    }

    public function getNomEleves()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT nom
            FROM user u
            WHERE u.roles LIKE "%ROLE_USER%"
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet;
    }

    public function getNomGerant()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT nom
            FROM user u
            WHERE u.roles LIKE "%ROLE_ADMIN%"
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet;
    }

    public function getVehiculeUtilisation(int $idCategorie): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(lecon.immatriculation_id),vehicule.immatriculation,vehicule.marque,vehicule.modele,vehicule.annee
            FROM   vehicule v , lecon l 
            WHERE  v.idcategorie_id =' . $idCategorie . 'AND l.immatriculation_id = v.immatriculation
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    
    public function leconNonPayee()
    {
        $userActuel = $this->getUser();
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(lecon.id)
            FROM lecon l , user u 
            WHERE l.relation_id=' . $userActuel . ' AND l.reglee = 0
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet;
    }


    public function getMoniteurSolicitation(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT COUNT(lecon.id),user.nom,user.prenom
            FROM   user u , lecon l 
            WHERE  l.relation_id = u.id AND u.roles=(SELECT user.roles
                                                     FROM   user u
                                                     WHERE  u.roles LIKE "%ROLE_MONITEUR%")       
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function planingLecon(\DateTime $dateDebut, \DateTime $dateFin): array
    {
        $userActuel = $this->getUser();
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT lecon.date,lecon.heure
            FROM lecon l , user u 
            WHERE u.id =' . $userActuel . ' AND u.id = l.relation_id AND l.date BETWEEN' . $dateDebut . '' and '' . $dateFin . '';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet;
    }

    public function getLicencePossede(): array
    {
        $userActuel = $this->getUser();
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
                    SELECT categorie.Libelle
                    FROM licence l 
                    inner join categorie on licence.codecategorie_id = categorie.codecategorie
                    INNER JOIN user on licence.relation_id=user.id
                    WHERE user.id=' . $userActuel . '';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet;
    }

    public function getLicenceNonPossede(): array
    {
        $userActuel = $this->getUser();
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
                    SELECT categorie.Libelle
                    FROM categorie c
                    WHERE c.CodeCategorie not IN(SELECT licence.codecategorie_id 
                                                 FROM licence l 
                                                 WHERE l.relation_id=' . $userActuel . ')
                    ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet;
    }

    public function findUsersByMoniteur()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where("u.roles LIKE '%ROLE_MONITEUR%'");

        return $qb->getQuery()->getResult();
    }

    public function findUsersByEleve()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where("u.roles LIKE '%ROLE_USER%'");

        return $qb->getQuery()->getResult();
    }

    public function findUsersByAdmin()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->where("u.roles LIKE '%ROLE_ADMIN%'");

        return $qb->getQuery()->getResult();
    }


}








//    /**
//     * @return User[] Returns an array of User objects
////     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//
//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//           ->andWhere('u.exampleField = :val')
//           ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
//}
