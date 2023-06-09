<?php

declare(strict_types=1);

namespace BitBag\ShopwareDpdApp\Factory;

use Vin\ShopwareSdk\Data\Context;

interface ContextFactoryInterface
{
    public function createByShopId(string $shopId): Context;
}
