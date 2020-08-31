<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

/**
 * This is a generic template tag that can be used for input into different template rendering engines
 */
interface TemplateTagInterface extends TagInterface
{
    /**
     * Returns the template to render
     */
    public function getTemplate(): string;

    /**
     * Returns the context to inject into the template
     */
    public function getContext(): array;

    /**
     * Overrides the current context
     */
    public function setContext(array $context): self;

    /**
     * Returns the template type. For example a twig template would return 'twig'
     * This is helpful when creating renderers that should support generic tags. At runtime these tags
     * can return the correct template type and subsequently be rendered by the correct renderer
     */
    public function getTemplateType(): string;
}
