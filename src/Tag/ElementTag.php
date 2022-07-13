<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

/**
 * This tag represents a HTML element, i.e. <script>, <link>, <style>, <div> etc
 */
class ElementTag extends Tag implements AttributesAwareInterface, ContentAwareInterface
{
    use AttributesAwareTrait;

    use ContentAwareTrait;

    protected string $element;

    protected bool $hasClosingElement;

    final private function __construct(string $element, string $content, bool $hasClosingElement, ?string $name)
    {
        parent::__construct($name ?? 'setono/element-tag');

        $this->content = $content;
        $this->element = $element;
        $this->hasClosingElement = $hasClosingElement;
    }

    /**
     * @return static
     */
    public static function createWithContent(string $element, string $content, string $name = null): self
    {
        return new static($element, $content, true, $name);
    }

    /**
     * @return static
     */
    public static function createWithoutContent(string $element, bool $hasClosingElement = true, string $name = null): self
    {
        return new static($element, '', $hasClosingElement, $name);
    }

    public function getElement(): string
    {
        return $this->element;
    }

    /**
     * @return static
     */
    public function withElement(string $element): self
    {
        return $this->with('element', $element);
    }

    public function hasClosingElement(): bool
    {
        return $this->hasClosingElement;
    }

    /**
     * @return static
     */
    public function noClosingElement(): self
    {
        return $this->with('hasClosingElement', false);
    }
}
