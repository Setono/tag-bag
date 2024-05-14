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

    final private function __construct(protected string $element, string $content, protected bool $closingElement)
    {
        $this->content = $content;
    }

    public static function createWithContent(string $element, string $content): static
    {
        return new static($element, $content, true);
    }

    public static function createWithoutContent(string $element, bool $hasClosingElement = true): static
    {
        return new static($element, '', $hasClosingElement);
    }

    public function getElement(): string
    {
        return $this->element;
    }

    public function withElement(string $element): static
    {
        return $this->with('element', $element);
    }

    public function hasClosingElement(): bool
    {
        return $this->closingElement;
    }

    public function withClosingElement(bool $closingElement): static
    {
        return $this->with('closingElement', $closingElement);
    }

    public function noClosingElement(): static
    {
        return $this->withClosingElement(false);
    }
}
