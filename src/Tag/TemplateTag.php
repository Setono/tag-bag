<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

class TemplateTag extends Tag implements TemplateTagInterface
{
    /** @var string */
    protected $name = 'setono_tag_bag_template_tag';

    /** @var string */
    protected $template;

    /** @var array */
    protected $context;

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
}
