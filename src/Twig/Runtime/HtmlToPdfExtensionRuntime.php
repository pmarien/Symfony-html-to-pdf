<?php

namespace PMA\HtmlToPdfBundle\Twig\Runtime;

use PMA\HtmlToPdfBundle\Asset\AssetAccessorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * @author Philipp Marien
 */
class HtmlToPdfExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly AssetAccessorInterface $accessor
    ) {
    }

    public function pdfAsset(string $filename): string
    {
        return $this->router->generate(
            'html_to_pdf_get_file',
            [
                'filename' => $filename,
                'hash' => $this->accessor->getHash($filename)
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
