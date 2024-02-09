<?php

namespace PMA\HtmlToPdfBundle\Asset;

use SplFileInfo;

/**
 * @author Philipp Marien
 */
interface AssetAccessorInterface
{
    public function getFile(string $filename, ?string $hash): SplFileInfo;

    public function getHash(string $filename): ?string;
}
