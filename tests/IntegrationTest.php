<?php

namespace KnpU\LoremIpsumBundle\Tests;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use KnpU\LoremIpsumBundle\WordProviderInterface;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

class IntegrationTest extends TestCase
{
    public function testServiceWiring()
    {
        $kernel = new KnpULoremIpsumTestingKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu_lorem_ipsum.knpu_ipsum');
        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);
        $this->assertIsString($ipsum->getParagraphs());
    }

    public function testServiceWiringWithConfiguration()
    {
        $kernel = new KnpULoremIpsumTestingKernel([
            'word_provider' => 'stub_word_list'
        ]);
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu_lorem_ipsum.knpu_ipsum');
        $this->assertStringContainsString('stub', $ipsum->getWords(2));
    }
}

class KnpULoremIpsumTestingKernel extends Kernel {
    private $knpUIpsumConfig;

    public function __construct(array $knpUIpsumConfig = [])
    {
        $this->knpUIpsumConfig = $knpUIpsumConfig;
        parent::__construct('test', true);
    }

    public function getCacheDir()
    {
        return __DIR__.'/cache/'.spl_object_hash($this);
    }

    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle()
        ];
        // TODO: Implement registerBundles() method.
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // TODO: Implement registerContainerConfiguration() method.
        $loader->load(function(ContainerBuilder $container) {
            $container->register('stub_word_list', StubWordList::class);
            $container->loadFromExtension('knpu_lorem_ipsum', $this->knpUIpsumConfig);
        });
    }
}

class StubWordList implements WordProviderInterface {
    public function getWordList(): array
    {
        // TODO: Implement getWordList() method.
        return ['stub', 'stub2'];
    }

}