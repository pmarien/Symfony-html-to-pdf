<?php

namespace PMA\HtmlToPdfBundle\DependencyInjection;

use PMA\HtmlToPdf\HtmlToPdf;
use PMA\HtmlToPdfBundle\Asset\AssetAccessor;
use PMA\HtmlToPdfBundle\Asset\AssetAccessorInterface;
use PMA\HtmlToPdfBundle\Bridge\FoundationBridge;
use PMA\HtmlToPdfBundle\Bridge\TwigBridge;
use PMA\HtmlToPdfBundle\Controller\AssetAccessController;
use PMA\HtmlToPdfBundle\Twig\Runtime\HtmlToPdfExtensionRuntime;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * @author Philipp Marien
 */
class HtmlToPdfExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $container->autowire(HtmlToPdf::class)
            ->setArgument('$apiKey', $mergedConfig['apiKey'])
            ->setPublic(false);

        $container->autowire(FoundationBridge::class)->setPublic(false);

        ##############################################################
        ### Asset Access
        ##############################################################
        $container->autowire(AssetAccessor::class)
            ->setArgument('$projectDir', $container->getParameter('kernel.project_dir'))
            ->setPublic(false);

        $container->setAlias(AssetAccessorInterface::class, AssetAccessor::class)
            ->setPublic(false);

        $container->autowire(AssetAccessController::class)
            ->addTag('controller.service_arguments')
            ->setPublic(true);

        ##############################################################
        ### Twig
        ##############################################################
        $container->autowire(TwigBridge::class)->setPublic(false);

        $container->autowire(HtmlToPdfExtensionRuntime::class)
            ->setPublic(false)
            ->addTag('twig.runtime');

        $container->autowire(\PMA\HtmlToPdfBundle\Twig\Extension\HtmlToPdfExtension::class)
            ->setPublic(false)
            ->addTag('twig.extension');

        ##############################################################
        ### Symfony Psr-Http-Message-Bridge
        ##############################################################
        if (!$container->hasDefinition(HttpMessageFactoryInterface::class)) {
            if (!$container->hasDefinition(PsrHttpFactory::class)) {
                $container->autowire(PsrHttpFactory::class)
                    ->setPublic(false);
            }

            $container->setAlias(HttpMessageFactoryInterface::class, PsrHttpFactory::class)
                ->setPublic(false);
        }

        if (!$container->hasDefinition(HttpFoundationFactoryInterface::class)) {
            if (!$container->hasDefinition(HttpFoundationFactory::class)) {
                $container->autowire(HttpFoundationFactory::class)
                    ->setPublic(false);
            }

            $container->setAlias(HttpFoundationFactoryInterface::class, HttpFoundationFactory::class)
                ->setPublic(false);
        }
    }
}
