<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

/**
 * The consentable inline script tag represents script tags in the form of <script type="text/plain">function foobar() {}</script>
 * These tags will not be evaluated by the browser because of the type="text/plain". This is particularly useful
 * when designing a consent management solution, and you want to output scripts that _can_ be run if the user consents
 */
final class ConsentableInlineScriptTag extends ElementTag
{
    /**
     * @return static
     */
    public static function create(string $content, string $consentType = null): self
    {
        $obj = parent::createWithContent('script', $content)
            ->withType('text/plain')
        ;

        if (null !== $consentType) {
            $obj = $obj->withAttribute('data-consent', $consentType);
        }

        return $obj;
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
