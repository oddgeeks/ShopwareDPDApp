<?php

declare(strict_types=1);

namespace BitBag\ShopwareDpdApp\Form\Type;

use BitBag\ShopwareDpdApp\Entity\Config;
use BitBag\ShopwareDpdApp\Entity\ConfigInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('salesChannelId', ChoiceType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.sales_channel',
                'required' => false,
                'choices' => $options['salesChannels'],
            ])
            ->add('apiLogin', TextType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.api_login',
                'required' => true,
            ])
            ->add('apiPassword', PasswordType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.api_password',
                'required' => true,
            ])
            ->add('apiFid', TextType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.api_fid',
                'required' => true,
            ])
            ->add('apiEnvironment', ChoiceType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.api_environment',
                'required' => true,
                'choices' => [
                    'bitbag.shopware_dpd_app.config.production_environment' => ConfigInterface::PRODUCTION_ENVIRONMENT,
                    'bitbag.shopware_dpd_app.config.sandbox_environment' => ConfigInterface::SANDBOX_ENVIRONMENT,
                ],
            ])
            ->add('senderFirstLastName', TextType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.sender_first_last_name',
                'required' => true,
            ])
            ->add('senderStreet', TextType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.sender_street',
                'required' => true,
            ])
            ->add('senderZipCode', TextType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.sender_zip_code',
                'required' => true,
            ])
            ->add('senderCity', TextType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.sender_city',
                'required' => true,
            ])
            ->add('senderPhoneNumber', TextType::class, [
                'label' => 'bitbag.shopware_dpd_app.config.sender_phone_number',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
            'salesChannels' => [],
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

    public function getName(): string
    {
        return 'config';
    }
}
