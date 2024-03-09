<?php

namespace Connor\DoReMi;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Loader\Configurator\RouteConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Application
{
    private RouteCollection $routes;
    private ContainerInterface $container;
    private Configuration $configuration;

    public const string ROOT_DIR = __DIR__.'/../';

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    public function boot(): void
    {
        $this->loadConfigs();
        $this->loadRoutes();
        $this->loadServices();
    }

    private function loadConfigs(): void
    {
        $defaultConfiguration = new Configuration();

        $configFile = self::ROOT_DIR . '/config/config.php';
        if (!is_file($configFile)) {
            Configurator::createConfiguration();
        }

        $configurator = require_once $configFile;
        $configurator($defaultConfiguration);

        $this->configuration = $defaultConfiguration;
    }

    private function loadRoutes(): void
    {
        $loader = new PhpFileLoader(new FileLocator());
        $this->routes = $loader->load(Application::ROOT_DIR.'/config/routes.php');
    }

    private function loadServices(): void
    {
        $serviceInit = require_once self::ROOT_DIR . '/config/services.php';
        $this->container = $serviceInit($this);
    }

    public static function initRequest(): Request
    {
        return Request::createFromGlobals();
    }

    public function handleRequest(Request $request): Response
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routes, $context);

        $attributes = $matcher->matchRequest($request);

        var_dump($attributes);

        exit;
    }
}
