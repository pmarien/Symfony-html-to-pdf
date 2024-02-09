<?php

namespace PMA\HtmlToPdfBundle\Bridge;

use PMA\HtmlToPdf\HtmlToPdf;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Philipp Marien
 */
class FoundationBridge
{
    public function __construct(
        private readonly HtmlToPdf $generator,
        private readonly HttpFoundationFactoryInterface $httpFactory
    ) {
    }

    public function createFile(string $filename, string $html): void
    {
        $this->generator->createFile($filename, $html);
    }

    public function inlineResponse(string $filename, string $html): Response
    {
        return $this->httpFactory->createResponse(
            $this->generator->inlineResponse($filename, $html)
        );
    }

    public function attachmentResponse(string $filename, string $html): Response
    {
        return $this->httpFactory->createResponse(
            $this->generator->attachmentResponse($filename, $html)
        );
    }
}
