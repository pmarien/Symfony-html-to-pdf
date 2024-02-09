<?php

namespace PMA\HtmlToPdfBundle\DependencyInjection;

use PMA\HtmlToPdf\HtmlToPdf;
use PMA\HtmlToPdfBundle\Bridge\FoundationBridge;
use PMA\HtmlToPdfBundle\Bridge\TwigBridge;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * @author Philipp Marien
 */
class HtmlToPdfExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        if ($container->has(RequestFactoryInterface::class)) {
            throw new RuntimeException(
                'No request factory available. Please install an implementation of psr/http-factory.',
                20240209140855
            );
        }
        if ($container->has(StreamFactoryInterface::class)) {
            throw new RuntimeException(
                'No stream factory available. Please install an implementation of psr/http-factory.',
                20240209140856
            );
        }
        if ($container->has(ResponseFactoryInterface::class)) {
            throw new RuntimeException(
                'No response factory available. Please install an implementation of psr/http-factory.',
                20240209140857
            );
        }
        if ($container->has(ClientInterface::class)) {
            throw new RuntimeException(
                'No http client available. Please install an implementation of psr/http-client.',
                20240209140858
            );
        }

        $container->autowire(HtmlToPdf::class)
            ->setArgument('$apiKey', $mergedConfig['apiKey'])
            ->setPublic(false);

        $container->autowire(FoundationBridge::class)->setPublic(false);

        if ($container->has('twig')) {
            $container->autowire(TwigBridge::class)->setPublic(false);
        }
    }
}
