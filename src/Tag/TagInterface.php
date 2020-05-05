<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

interface TagInterface
{
    /**
     * These are just default sections, you can use your own section
     */
    public const SECTION_HEAD = 'head';

    public const SECTION_BODY_BEGIN = 'body_begin';

    public const SECTION_BODY_END = 'body_end';

    /**
     * The section where this tag belongs.
     *
     * If it returns null, it doesn't matter where the tag is output
     */
    public function getSection(): ?string;

    /**
     * Returns the key for this tag.
     *
     * This is used as a key for each tag in a given section which in turn
     * means that you can't add multiple tags with the same key in a given section.
     */
    public function getKey(): string;

    /**
     * An array of tag keys which this tag depends on
     *
     * The tag will search through all sections looking for the dependents. It is therefore up to you to control
     * the order of outputted tags both having the section and priority in mind
     *
     * @return string[]
     */
    public function getDependents(): array;

    /**
     * The priority of this tag. The lower the number, the later the tag will be output
     *
     * The default priority is 0
     *
     * Example
     *
     * Tag 1 has priority 10
     * Tag 2 has priority -10
     * Tag 3 has priority 0
     *
     * These tags output in the following order: Tag 1, Tag 3, Tag 2
     */
    public function getPriority(): int;

    /**
     * Returns true if this tag replaces an existing tag with the same key
     *
     * If this is false, the tag bag will add both tags to the same key
     *
     * Defaults to true
     */
    public function willReplace(): bool;
}
