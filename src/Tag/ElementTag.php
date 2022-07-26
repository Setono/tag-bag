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

    protected bool $closingElement;

    final private function __construct(string $element, string $content, bool $hasClosingElement)
    {
        $this->content = $content;
        $this->element = $element;
        $this->closingElement = $hasClosingElement;
    }

    /**
     * @return static
     */
    public static function createWithContent(string $element, string $content): self
    {
        return new static($element, $content, true);
    }

    /**
     * @return static
     */
    public static function createWithoutContent(string $element, bool $hasClosingElement = true): self
    {
        return new static($element, '', $hasClosingElement);
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
        return $this->closingElement;
    }

    /**
     * @return static
     */
    public function withClosingElement(bool $closingElement): self
    {
        return $this->with('closingElement', $closingElement);
    }

    /**
     * @return static
     */
    public function noClosingElement(): self
    {
        return $this->withClosingElement(false);
    }
}
