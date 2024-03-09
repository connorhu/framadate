<?php

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Application
{
    private RouteCollection $routes;
    private ContainerInterface $container;

    private const string ROOT_DIR = __DIR__.'/../';

    public function boot(): void
    {
        $this->loadConfigs();
        $this->loadRoutes();
        $this->loadServices();
    }

    private function loadConfigs(): void
    {
    }

    private function loadRoutes(): void
    {
        $this->routes = require_once self::ROOT_DIR . '/config/router.php';
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

        return new Response('');
    }
}
