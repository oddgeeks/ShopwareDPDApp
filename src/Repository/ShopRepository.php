<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSkeleton\Repository;

use BitBag\ShopwareAppSkeleton\AppSystem\Exception\ShopNotFoundException;
use BitBag\ShopwareAppSkeleton\Entity\Shop;
use BitBag\ShopwareAppSkeleton\Entity\ShopInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ShopRepository extends ServiceEntityRepository implements ShopRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    public function findSecretByShopId(string $shopId): ?string
    {
        $queryBuilder = $this->createQueryBuilder('shop');
        $queryBuilder
            ->select('s.shopSecret')
            ->from('App:Shop', 's')
            ->where('shop.shopId = :shopId')
            ->setParameter('shopId', $shopId);

        /* @var ?string */
        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function getOneByShopId(string $shopId): ShopInterface
    {
        $shop = $this->find($shopId);

        if (null === $shop) {
            throw new ShopNotFoundException($shopId);
        }

        return $shop;
    }
}
