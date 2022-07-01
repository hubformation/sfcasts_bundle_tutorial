<?php

namespace KnpU\LoremIpsumBundle\DependencyInjection;

use KnpU\LoremIpsumBundle\WordProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class KnpULoremIpsumExtension extends Extension
{

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // TODO: Implement load() method.
        //var_dump($configs);
        //die;
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config') );
        $loader->load('services.xml');
        $configuration = $this->getConfiguration($configs,$container);
        $config = $this->processConfiguration($configuration, $configs);
        // var_dump($config);die;
        $definition = $container->getDefinition('knpu_lorem_ipsum.knpu_ipsum');
        $definition->setArgument(1, $config['unicorns_are_real']);
        $definition->setArgument(2, $config['min_sunshine']);

        $container->registerForAutoconfiguration(WordProviderInterface::class)
            ->addTag('knpu_ipsum_word_provider');
    }

    public function getAlias()
    {
        return "knpu_lorem_ipsum";
    }

}