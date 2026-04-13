<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use const PATHINFO_EXTENSION;

final class TemplateTag extends Tag
{
    private function __construct(protected string $template, protected array $data = [])
    {
    }

    public static function create(string $template, array $data = []): self
    {
        return new self($template, $data);
    }

    /**
     * Returns the template to render
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    public function withTemplate(string $template): self
    {
        return $this->with('template', $template);
    }

    /**
     * Returns the data to inject into the template
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function withData(array $data): self
    {
        return $this->with('data', $data);
    }

    /**
     * Returns the template type. For example a twig template would return 'twig'
     * This is helpful when creating renderers that should support generic tags. At runtime these tags
     * can return the correct template type and subsequently be rendered by the correct renderer
     */
    public function getTemplateType(): string
    {
        return strtolower(pathinfo($this->template, PATHINFO_EXTENSION));
    }
}
