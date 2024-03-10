<?php

namespace Connor\DoReMi\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\Attribute\SubscribedService;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;
use Twig\Environment;

class DefaultController implements ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    #[SubscribedService]
    private function getTwig(): Environment
    {
        return $this->container->get(__METHOD__);
    }

    private function render(string $templateName, array $context = [], int $statusCode = 200): Response
    {
        return new Response($this->getTwig()->render($templateName, $context), status: $statusCode);
    }

    public function main(): Response
    {
        return $this->render('index.twig');
    }
}
