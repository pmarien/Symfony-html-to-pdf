<?php

namespace PMA\HtmlToPdfBundle\DependencyInjection;

use PMA\HtmlToPdf\HtmlToPdf;
use PMA\HtmlToPdfBundle\Bridge\FoundationBridge;
use PMA\HtmlToPdfBundle\Bridge\TwigBridge;
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

        $container->autowire(TwigBridge::class)->setPublic(false);

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
