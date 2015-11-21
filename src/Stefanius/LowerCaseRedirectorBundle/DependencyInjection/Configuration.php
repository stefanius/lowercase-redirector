<?php

namespace Stefanius\LowerCaseRedirectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('stefanius_lower_case_redirector');

        //$rootNode = $treeBuilder->root('stefanius_lower_case_redirector');
        //-> enable above line again when the $rootNode is used.

        return $treeBuilder;
    }
}
