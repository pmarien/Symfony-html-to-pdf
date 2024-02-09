<?php

namespace PMA\HtmlToPdfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Philipp Marien
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('html_to_pdf');
        $root = $builder->getRootNode()->addDefaultsIfNotSet()->children();

        $root->scalarNode('apiKey')->defaultNull();

        return $builder;
    }
}
