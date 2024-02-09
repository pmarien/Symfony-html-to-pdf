<?php

namespace PMA\HtmlToPdfBundle\Twig\Runtime;

use PMA\HtmlToPdfBundle\Asset\AssetAccessorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Twig\Markup;

/**
 * @author Philipp Marien
 */
class HtmlToPdfExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly AssetAccessorInterface $accessor,
        private readonly ?string $assetScheme = null,
        private readonly ?string $assetHost = null,
    ) {
    }

    public function pdfAsset(string $filename): Markup
    {
        $context = clone $this->router->getContext();

        $pdfContext = clone $context;
        if ($this->assetScheme) {
            $pdfContext->setScheme($this->assetScheme);
        }
        if ($this->assetHost) {
            $pdfContext->setHost($this->assetHost);
        }
        $this->router->setContext($pdfContext);

        $markup = new Markup(
            $this->router->generate(
                'html_to_pdf_get_file',
                [
                    'filename' => $filename,
                    'hash' => $this->accessor->getHash($filename)
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'utf-8'
        );

        $this->router->setContext($context);

        return $markup;
    }
}
