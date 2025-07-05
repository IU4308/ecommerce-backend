<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
class ProductGalleryRepository
{
    public function __construct(private Connection $db)
    {
    }

    public function get(string $productId): array
    {
        return $this->db->createQueryBuilder()
            ->select('image_url')
            ->from('product_gallery')
            ->where('product_id = :id')
            ->setParameter('id', $productId)
            ->executeQuery()
            ->fetchFirstColumn();
    }
}
