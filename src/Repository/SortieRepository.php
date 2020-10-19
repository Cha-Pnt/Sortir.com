<?php

namespace App\Repository;

use App\Data\Recherche;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    //Récupère les sorties selon les critères de recherche
    public function findByParametres( Recherche $parametres, $user,$repoParticipant):array
    {

        $participant = $repoParticipant->findById($user);
        $qb = $this->createQueryBuilder('s');

        if (!empty ($parametres->search)) {
            $qb = $qb
                ->andWhere('s.nom LIKE :q')
                ->setParameter('q', "%{$parametres->search}%");
        }
        if (!empty ($parametres->campus)) {
            $qb = $qb
                ->join('s.campus', 'c')
                ->andWhere('c.id IN (:campus)')
                ->setParameter('campus', $parametres->campus);
        }
        if (!empty ($parametres->dateDebut) && ($parametres->dateLimite)) {
            $qb = $qb
                ->andWhere('s.dateHeureDebut >= :dateDebut ')
                ->setParameter('dateDebut', $parametres->dateDebut)
                ->andWhere('s.dateLimite <= :dateLimite')
                ->setParameter('dateLimite', $parametres->dateLimite);
        }
        if (!empty ($parametres->organisateur)) {
            $qb = $qb
                ->andWhere('s.organisateur = :user')
                ->setParameter('user', $participant);
        }
        if($parametres->inscription) {
            if (($parametres->inscription) == "oui") {
                $qb = $qb
                    ->join('s.inscriptions', 'i')
                    ->andWhere('i.participant = :user')
                    ->setParameter('user', $participant);
            } else if (($parametres->inscription) == 'non') {
                $qb = $qb
                    ->join('s.inscriptions', 'i')
                    ->andWhere('i.participant != :user')
                    ->andWhere('i is null')
                    ->setParameter('user', $participant);
            }
        }
        if(!empty($parametres->etat)){
            $qb ->join('s.etat','e')
                ->andWhere('e.id IN (:etat)')
                ->setParameter('etat', $parametres->etat);
        }
        return $qb->getQuery()->getResult();

    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
