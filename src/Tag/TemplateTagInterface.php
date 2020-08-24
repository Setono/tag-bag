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
}
