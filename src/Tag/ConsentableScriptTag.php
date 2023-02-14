<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

/**
 * The script tag represents script tags in the form of <script type="text/plain" src="..."></script>
 */
final class ConsentableScriptTag extends ElementTag
{
    /**
     * @return static
     */
    public static function create(string $src, string $consentType = null): self
    {
        $obj = parent::createWithoutContent('script')
            ->withSrc($src)
            ->withType('text/plain')
        ;

        if (null !== $consentType) {
            $obj = $obj->withAttribute('data-consent', $consentType);
        }

        return $obj;
    }

    /**
     * Returns the src attribute value for the <script src="..."> tag
     */
    public function getSrc(): ?string
    {
        return $this->attributes['src'] ?? null;
    }

    /**
     * @return static
     */
    public function withSrc(string $src): self
    {
        return $this->withAttribute('src', $src);
    }

    /**
     * Returns the type attribute for the <script type="..."> tag
     */
    public function getType(): ?string
    {
        return $this->attributes['type'] ?? null;
    }

    /**
     * @return static
     */
    public function withType(string $type): self
    {
        return $this->withAttribute('type', $type);
    }
}
