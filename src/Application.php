<?php

namespace Connor\DoReMi;

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Application
{
    private RouteCollection $routes;
    private ContainerInterface $container;
    private Configuration $configuration;

    public const string ROOT_DIR = __DIR__.'/..';

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return RouteCollection
     */
    public function getRoutes(): RouteCollection
    {
        return $this->routes;
    }

    public function getRequestContext(?Request $request = null): RequestContext
    {
        $context = new RequestContext();
        $context->fromRequest($request ?? self::initRequest());
        return $context;
    }

    public function boot(): void
    {
        $this->getRequestContext();
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

    private function getController($className): object
    {
        if (!$this->container->has($className)) {
            throw new \RuntimeException('controller not found');
        }

        return $this->container->get($className);
    }

    public function handleRequest(Request $request): Response
    {
        $matcher = new UrlMatcher($this->routes, $this->getRequestContext($request));

        $attributes = $matcher->matchRequest($request);

        [$controllerName, $methodName] = $attributes['_controller'];
        $controller = $this->getController($controllerName);

        $response = $controller->{$methodName}($request);

        if (!$response instanceof Response) {
            throw new \RuntimeException('invalid response');
        }

        return $response;
    }
}
