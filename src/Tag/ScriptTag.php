<?php

declare(strict_types=1);

namespace Setono\TagBag\Tag;

final class ScriptTag extends ContentTag implements ScriptTagInterface
{
    /** @var string|null */
    private $type;

    public function __construct(string $content)
    {
        parent::__construct($content);

        $this->setName('setono_tag_bag_script_tag');
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
