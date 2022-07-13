<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

interface TagInterface
{
    /**
     * These are just default sections, you can use your own section
     */

    /**
     * Inside the <head> tag
     */
    public const SECTION_HEAD = 'head';

    /**
     * Just after the <body> tag
     */
    public const SECTION_BODY_BEGIN = 'body_begin';

    /**
     * Just before the </body> tag
     */
    public const SECTION_BODY_END = 'body_end';

    /**
     * Returns the name for this tag. The name is used in dependency checking. It is good practice using a namespace
     * when naming your tag, i.e. 'setono/style-tag' could be a name for the StyleTag instead of just 'style-tag'
     */
    public function getName(): string;

    /**
     * The section where this tag belongs. See SECTION_ constants above
     */
    public function getSection(): string;

    /**
     * The priority of this tag. The lower the number, the later the tag will be outputted
     *
     * The default priority is 0
     *
     * Example
     *
     * Tag 1 has priority 10
     * Tag 2 has priority -10
     * Tag 3 has priority 0
     *
     * These tags will be outputted in the following order:
     *
     * 1. Tag 1
     * 2. Tag 3
     * 3. Tag 2
     */
    public function getPriority(): int;

    /**
     * If a tag is set to unique, it means that no other tags with the same fingerprint can be added.
     * Returns true by default
     */
    public function isUnique(): bool;

    /**
     * If this method returns null, a fingerprint generator will be used
     */
    public function getFingerprint(): ?string;
}
