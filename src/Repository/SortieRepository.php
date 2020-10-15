<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function findByParametres($parametres, $user){

        //Récupération des données du formulaire
        $campus = $parametres['campus'];
        $titre = $parametres['nom'];
        $dateHeureDebut =$parametres['dateHeureDebut'];
        $dateLimite=$parametres['dateLimite'];
        $organisateur=$parametres['organisateur'];
        $inscrit=$parametres['inscrit'];
        $nonInscrit=$parametres['nonInscrit'];
        $etat=$parametres['etat'];

        $qb = $this->createQueryBuilder('s');
        if($campus='All') {
            $qb->select('*')
                ->from('Sortie','s');
        }else {
            $qb->select('s')
                ->from('sortie','s')
                ->where('s.campus = :campus')
                ->setParameter('campus',$campus);
        }
        if($titre){
            $qb->andWhere('s.nom = :titre')
                ->setParameter('titre',$titre);
            if($dateHeureDebut && $dateLimite) {
           $qb->andWhere('s.dateHeureDebut BETWEEN ?1 AND ?2')
                ->setParameters(array($dateHeureDebut,$dateLimite));
        }if($organisateur) {
            $qb->andWhere('s.organisateur = :organisateur')
                ->setParameter('organisateur', $user);
        }if($inscrit){
            $inscrit = $user->getInscription();
            $qb->andWhere('s.inscription = :inscriptionUser')
                ->setParameter('inscriptionUser',$inscrit);
        }if($nonInscrit) {
            $inscrit = $user->getInscription();
            $qb->andWhere('s.inscription != :inscriptionUser')
                ->setParameter('inscriptionUser', $inscrit);
        }if($etat){
            $qb->andWhere('s.inscription != :inscriptionUser')
                ->setParameter('inscriptionUser', $inscrit);
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
