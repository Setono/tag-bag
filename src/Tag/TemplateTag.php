<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use const PATHINFO_EXTENSION;

class TemplateTag extends Tag implements TemplateTagInterface
{
    protected string $template;

    protected array $data;

    final private function __construct(string $template, array $data = [], string $name = null)
    {
        parent::__construct($name ?? 'setono/template-tag');

        $this->template = $template;
        $this->data = $data;
    }

    /**
     * @return static
     */
    public static function create(string $template, array $data = [], string $name = null): self
    {
        return new static($template, $data, $name);
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return static
     */
    public function withTemplate(string $template): self
    {
        return $this->with('template', $template);
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return static
     */
    public function withData(array $data): self
    {
        return $this->with('data', $data);
    }

    public function getTemplateType(): string
    {
        return strtolower(pathinfo($this->template, PATHINFO_EXTENSION));
    }
}
