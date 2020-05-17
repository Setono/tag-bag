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
     * Returns the name for this tag. The name is used in dependency checking. It is good practice to use a namespace
     * when naming your tag, i.e. 'setono_tag_bag_style_tag' could be a name for the StyleTag instead of just 'style_tag'
     */
    public function getName(): string;

    /**
     * An array of tag names which this tag depends on
     *
     * The tag will search through all sections looking for the dependents. It is therefore up to you to control
     * the order of outputted tags both having the section and priority in mind
     *
     * @return string[]
     */
    public function getDependencies(): array;

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
}
