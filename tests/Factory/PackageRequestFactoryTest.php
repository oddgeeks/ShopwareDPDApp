<?php

declare(strict_types=1);

namespace BitBag\ShopwareDpdApp\Tests\Factory;

use BitBag\ShopwareDpdApp\Factory\DpdSenderFactoryInterface;
use BitBag\ShopwareDpdApp\Factory\PackageRequestFactory;
use BitBag\ShopwareDpdApp\Factory\ParcelFactoryInterface;
use BitBag\ShopwareDpdApp\Factory\ReceiverFactoryInterface;
use BitBag\ShopwareDpdApp\Resolver\OrderCustomFieldsResolverInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use T3ko\Dpd\Objects\Package;
use T3ko\Dpd\Objects\Parcel;
use T3ko\Dpd\Objects\Receiver;
use T3ko\Dpd\Objects\Sender;
use T3ko\Dpd\Request\GeneratePackageNumbersRequest;
use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Data\Entity\Order\OrderEntity;
use Vin\ShopwareSdk\Data\Uuid\Uuid;

final class PackageRequestFactoryTest extends WebTestCase
{
    public function testCreate(): void
    {
        $dpdSenderFactory = $this->createMock(DpdSenderFactoryInterface::class);
        $dpdSenderFactory->expects(self::once())
            ->method('create')
            ->willReturn($this->getSender());

        $orderCustomFieldsResolver = $this->createMock(OrderCustomFieldsResolverInterface::class);
        $orderCustomFieldsResolver->expects(self::once())
                                  ->method('resolve')
                                  ->willReturn(['insurance' => null]);

        $parcelFactory = $this->createMock(ParcelFactoryInterface::class);
        $parcelFactory->expects(self::once())
            ->method('create')
            ->willReturn($this->getParcel());

        $receiverFactory = $this->createMock(ReceiverFactoryInterface::class);
        $receiverFactory->expects(self::once())
            ->method('create')
            ->willReturn($this->getReceiver());

        $packageRequestFactory = new PackageRequestFactory(
            $dpdSenderFactory,
            $orderCustomFieldsResolver,
            $parcelFactory,
            $receiverFactory
        );

        $context = $this->createMock(Context::class);

        $package = $this->getPackage();

        self::assertEquals(
            GeneratePackageNumbersRequest::fromPackage($package),
            $packageRequestFactory->create(Uuid::randomHex(), new OrderEntity(), $context)
        );
    }

    private function getSender(): Sender
    {
        return new Sender(
            1234,
            '123-123-123',
            'Jan Kowalski',
            'Jasna 4',
            '12-123',
            'Wrocław',
            'PL'
        );
    }

    private function getReceiver(): Receiver
    {
        return new Receiver(
            '222-333-444',
            'Władysław Kowalski',
            'Jasna 5',
            '12-123',
            'Wrocław',
            'PL'
        );
    }

    private function getParcel(): Parcel
    {
        return new Parcel(12, 12, 12, 2.5);
    }

    private function getPackage(): Package
    {
        $sender = $this->getSender();
        $receiver = $this->getReceiver();
        $parcel = $this->getParcel();

        return new Package($sender, $receiver, [$parcel]);
    }
}
