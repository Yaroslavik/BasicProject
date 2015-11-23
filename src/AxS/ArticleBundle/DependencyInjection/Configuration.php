<?php
/**
 * Created by PhpStorm.
 * User: alexsholk
 * Date: 20.11.15
 * Time: 20:37
 */

namespace AxS\ArticleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('axs_article');

        $rootNode
            ->children()
                ->scalarNode('date_format')->end()
                ->booleanNode('use_categories')
                    ->defaultTrue()
                ->end()
            ->end();

        return $treeBuilder;
    }
}