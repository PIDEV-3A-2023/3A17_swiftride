<?php 

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classroom>
 *
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

 class VoitureRepository extends ServiceEntityRepository 
 {

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry ,Voiture::class);
    }


    public function save(Voiture $entity , bool $flush =false):void
    {
        $this->getEntityManager()->persist($entity);
        if($flush){
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Voiture $entity, bool $flush=false):void
    {
        $this->getEntityManager()->remove($entity);

        if($flush){
            $this->getEntityManager()->flush();
        }
    }

    public function getGarageWithMatricule($matricule){

        return $this->createQueryBuilder('g')
        ->where('g.id LIKE :mat')
        ->setParameter('mat',$matricule)
        ->getQuery()
        ->getResult();
    }

    public function getCarsWithPartnerId($id){
        return $this->createQueryBuilder('c')
        ->where('c.idEntreprisePartenaire = :id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();
    }

 }
