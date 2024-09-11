<?php

namespace App\Repository;

use App\Entity\RentalDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RentalDocument>
 */
class RentalDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentalDocument::class);
    }

    /**
     * Get a rental using filters
     */
    public function findFilteredRentals($filters)
    {
        $qb = $this->createQueryBuilder('d');

        // Join the Rental entity to access its properties
        $qb->leftJoin('d.rental', 'r')
        ->leftJoin('r.property', 'p');

        // Filter by Property (e.g., using Property ID)
        if (!empty($filters['property'])) {
            $qb->andWhere('p.id = :property')  // Use 'p.id' if 'property' is an ID
            ->setParameter('property', $filters['property']);
        }

        // Additional filters, e.g., by status
        if (!empty($filters['status'])) {
            $qb->andWhere('d.status = :status')
            ->setParameter('status', $filters['status']);
        }

        return $qb->getQuery()->getResult();
    }
}
