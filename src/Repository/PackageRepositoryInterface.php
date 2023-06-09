<?php

declare(strict_types=1);

namespace BitBag\ShopwareDpdApp\Repository;

use BitBag\ShopwareDpdApp\Entity\Package;

interface PackageRepositoryInterface
{
    public function getByOrderId(string $orderId): Package;

    public function findByOrderId(string $orderId): ?Package;
}
