<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class ScriptTag extends ContentTag implements TypeAwareInterface
{
    public function __construct(string $content)
    {
        parent::__construct($content);

        $this->setName('setono_tag_bag_script_tag');
    }

    public function getType(): string
    {
        return TypeAwareInterface::TYPE_SCRIPT;
    }
}
