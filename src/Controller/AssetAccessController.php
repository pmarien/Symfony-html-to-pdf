<?php

namespace PMA\HtmlToPdfBundle\Controller;

use PMA\HtmlToPdfBundle\Asset\AssetAccessorInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @author Philipp Marien
 */
class AssetAccessController
{
    public function __construct(private readonly AssetAccessorInterface $accessor)
    {
    }

    #[Route(path: '/html-to-pdf/get-file', name: 'html_to_pdf_get_file', methods: ['GET'])]
    public function getFile(Request $request): Response
    {
        return new BinaryFileResponse(
            $this->accessor->getFile(
                $request->query->get('filename'),
                $request->query->get('hash')
            )
        );
    }
}
