<?php

declare(strict_types=1);

namespace BitBag\ShopwareDpdApp\Resolver;

use BitBag\ShopwareDpdApp\Exception\PackageException;
use Vin\ShopwareSdk\Data\Entity\Order\OrderEntity;

final class OrderCustomFieldsResolver implements OrderCustomFieldsResolverInterface
{
    public function resolve(OrderEntity $order): array
    {
        $packageDetailsKey = self::PACKAGE_DETAILS_KEY;

        /**
         * @psalm-var array<array-key, mixed>|null
         */
        $orderCustomFields = $order->getCustomFields();

        if (empty($orderCustomFields)) {
            throw new PackageException('bitbag.shopware_dpd_app.package.fill_required_custom_fields');
        }

        $depthKey = $packageDetailsKey . '_depth';
        $heightKey = $packageDetailsKey . '_height';
        $widthKey = $packageDetailsKey . '_width';
        $packageContentsKey = $packageDetailsKey . '_package_contents';

        if (!isset(
            $orderCustomFields[$depthKey],
            $orderCustomFields[$heightKey],
            $orderCustomFields[$widthKey],
            $orderCustomFields[$packageContentsKey]
        )) {
            throw new PackageException('bitbag.shopware_dpd_app.package.fill_required_custom_fields');
        }

        if (0 === $orderCustomFields[$depthKey] ||
            0 === $orderCustomFields[$heightKey] ||
            0 === $orderCustomFields[$widthKey]
        ) {
            throw new PackageException('bitbag.shopware_dpd_app.package.fill_required_custom_fields');
        }

        return [
            'depth' => $orderCustomFields[$depthKey],
            'height' => $orderCustomFields[$heightKey],
            'width' => $orderCustomFields[$widthKey],
            'package_contents' => $orderCustomFields[$packageContentsKey],
        ];
    }
}
