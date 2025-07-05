<?php

namespace App\Repository;

use App\Model\ProductPrice;
use Doctrine\DBAL\Connection;
class ProductPriceRepository
{
    public function __construct(private Connection $db)
    {
    }

    private function get(string $productId): ProductPrice
    {
        $row = $this->db->createQueryBuilder()
            ->select('*')
            ->from('product_prices')
            ->where('product_id = :id')
            ->setParameter('id', $productId)
            ->executeQuery()
            ->fetchAssociative();

        return new ProductPrice(
            product_id: $row['product_id'],
            currency_label: $row['currency_label'],
            currency_symbol: $row['currency_symbol'],
            amount: (float) $row['amount']
        );
    }
}
