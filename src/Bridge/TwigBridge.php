<?php

namespace PMA\HtmlToPdfBundle\Bridge;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @author Philipp Marien
 */
class TwigBridge
{
    public function __construct(private readonly FoundationBridge $generator, private readonly Environment $twig)
    {
    }

    /**
     * @throws Exception
     */
    public function createFile(string $filename, string $template, array $context): void
    {
        $this->generator->createFile(
            $filename,
            $this->twig->render($template, $context)
        );
    }

    /**
     * @throws Exception
     */
    public function inlineResponse(string $filename, string $template, array $context): Response
    {
        return $this->generator->inlineResponse(
            $filename,
            $this->twig->render($template, $context)
        );
    }

    /**
     * @throws Exception
     */
    public function attachmentResponse(string $filename, string $template, array $context): Response
    {
        return $this->generator->attachmentResponse(
            $filename,
            $this->twig->render($template, $context)
        );
    }
}
