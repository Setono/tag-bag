<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

use const PATHINFO_EXTENSION;

class TemplateTag extends Tag implements TemplateTagInterface
{
    protected string $name = 'setono_tag_bag_template_tag';

    protected string $template;

    protected array $context;

    public function __construct(string $template, array $context = [])
    {
        $this->template = $template;
        $this->context = $context;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function setContext(array $context): TemplateTagInterface
    {
        $this->context = $context;

        return $this;
    }

    public function getTemplateType(): string
    {
        return mb_strtolower(pathinfo($this->template, PATHINFO_EXTENSION));
    }
}
