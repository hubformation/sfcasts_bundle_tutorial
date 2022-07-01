<?php

namespace KnpU\LoremIpsumBundle\Tests\Controller;

use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use KnpU\LoremIpsumBundle\Tests\StubWordList;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class IpsumApiControllerTest extends TestCase
{
    public function testIndex()
    {
        $kernel = new KnpULoremIpsumControllerKernel();
        $client = new Client($kernel);
        $client->request('GET', '/api/');
        var_dump($client->getResponse()->getContent());
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }


}

class KnpULoremIpsumControllerKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function getCacheDir()
    {
        return __DIR__ . '/../cache/' . spl_object_hash($this);
    }

    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle(),
            new FrameworkBundle()
        ];
        // TODO: Implement registerBundles() method.
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        // TODO: Implement configureRoutes() method.
        $routes->import(__DIR__.'/../../src/Resources/config/routes.xml', '/api');
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        // TODO: Implement configureContainer() method.
        $container->loadFromExtension('framework', [
            'secret' => 'F00'
        ]);
    }


}