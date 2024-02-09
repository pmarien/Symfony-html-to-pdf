<?php

namespace PMA\HtmlToPdfBundle\Controller;

use PMA\HtmlToPdfBundle\Asset\AssetAccessorInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Philipp Marien
 */
class AssetAccessController
{
    public function __construct(private readonly AssetAccessorInterface $accessor)
    {
    }

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
