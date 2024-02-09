<?php

namespace PMA\HtmlToPdfBundle\Asset;

use SplFileInfo;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

/**
 * @author Philipp Marien
 */
class AssetAccessor implements AssetAccessorInterface
{
    public function __construct(private readonly string $projectDir)
    {
    }

    public function getFile(string $filename, ?string $hash): SplFileInfo
    {
        $file = $this->getSplFileInfo($filename);

        if ($this->getHash($filename) !== $hash) {
            throw new AccessDeniedException($filename);
        }

        return $file;
    }

    public function getHash(string $filename): ?string
    {
        $file = $this->getSplFileInfo($filename);

        return sha1($file->openFile()->fread($file->getSize()));
    }

    protected function getSplFileInfo(string $filename): SplFileInfo
    {
        return new SplFileInfo(
            rtrim($this->projectDir, '/') . '/' . ltrim($filename, '/')
        );
    }
}
