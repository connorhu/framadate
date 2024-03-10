<?php

namespace Connor\DoReMi\Twig\Extensions;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\Node\Expression\ArrayExpression;
use Twig\Node\Expression\ConstantExpression;
use Twig\Node\Node;
use Twig\TwigFunction;

/**
 * File from \Symfony\Bridge\Twig\Extension\RoutingExtension
 */
final class RoutingExtension extends AbstractExtension
{
    public function __construct(
        private readonly UrlGenerator $generator
    ) {

    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('url', $this->generateUrl(...), ['is_safe_callback' => $this->isUrlGenerationSafe(...)]),
            new TwigFunction('path', $this->generatePath(...), ['is_safe_callback' => $this->isUrlGenerationSafe(...)]),
        ];
    }

    public function generateUrl(string $name, array $parameters = [], bool $relative = false): string
    {
        return $this->generator->generate($name, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    public function generatePath(string $name, array $parameters = [], bool $schemeRelative = false): string
    {
        return $this->generator->generate($name, $parameters, $schemeRelative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    public function isUrlGenerationSafe(Node $argsNode): array
    {
        // support named arguments
        $paramsNode = $argsNode->hasNode('parameters')
            ? $argsNode->getNode('parameters')
            : ($argsNode->hasNode(1) ? $argsNode->getNode(1) : null);

        if (null === $paramsNode || $paramsNode instanceof ArrayExpression && \count($paramsNode) <= 2
            && (!$paramsNode->hasNode(1) || $paramsNode->getNode(1) instanceof ConstantExpression)
        ) {
            return ['html'];
        }

        return [];
    }
}
