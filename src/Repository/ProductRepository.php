<?php

namespace App\Repository;

use App\Model\Product;
use App\Model\ProductPrice;
use Doctrine\DBAL\Connection;

class ProductRepository
{
    public function __construct(
        private Connection $db,
        private AttributeRepository $attributeRepo,
        private ProductGalleryRepository $galleryRepo,
    ) {
        Product::setConnection($db);
    }

    public function getProductDetails(string $productId): Product
    {
        $row = Product::get($productId);
        if (!$row) {
            throw new \RuntimeException("Product not found: $productId");
        }

        $product = Product::fromArray($row);
        $product->price = $this->getPrice($productId);
        $product->gallery = $this->galleryRepo->get($productId);
        $product->attributes = $this->attributeRepo->get($productId);

        return $product;
    }

    private function getPrice(string $productId): ProductPrice
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

    public function getHomeListing(): array
    {
        $rows = $this->fetchHomeListingRows();
        return array_map([$this, 'mapRowToProduct'], $rows);
    }

    private function fetchHomeListingRows(): array
    {
        return $this->db->createQueryBuilder()
            ->select(
                'p.id',
                'p.name',
                'p.brand',
                'p.category',
                'p.in_stock',
                'pp.amount',
                'pp.currency_label',
                'pp.currency_symbol',
                'pg.image_url'
            )
            ->from('products', 'p')
            ->leftJoin('p', 'product_prices', 'pp', 'pp.product_id = p.id')
            ->leftJoin('p', '(SELECT product_id, MIN(id) AS min_id FROM product_gallery GROUP BY product_id)', 'pg_min', 'pg_min.product_id = p.id')
            ->leftJoin('p', 'product_gallery', 'pg', 'pg.id = pg_min.min_id')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function mapRowToProduct(array $row): BaseProduct
    {
        $gallery = [$row['image_url']];

        return $this->buildProductFromRow($row, $gallery);
    }

    private function buildProductFromRow(array $row, array $gallery, array $attributes = []): BaseProduct
    {
        $price = new ProductPrice(
            productId: $row['id'],
            amount: (float) $row['amount'],
            currencyLabel: $row['currency_label'],
            currencySymbol: $row['currency_symbol']
        );

        return $this->createProductInstance($row['category'], [
            $row['id'],
            $row['name'],
            $row['brand'],
            $row['category'],
            (bool) $row['in_stock'],
            $price,
            $gallery,
            $attributes,
            $row['description'] ?? '',
        ]);
    }




}

