<?php

namespace PMA\HtmlToPdfBundle\Twig\Extension;

use PMA\HtmlToPdfBundle\Twig\Runtime\HtmlToPdfExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * @author Philipp Marien
 */
class HtmlToPdfExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('pdfAsset', [HtmlToPdfExtensionRuntime::class, 'pdfAsset'])
        ];
    }
}
