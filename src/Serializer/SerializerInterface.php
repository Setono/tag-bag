<?php

declare(strict_types=1);

namespace Setono\TagBag\Serializer;

use Setono\TagBag\Exception\SerializationException;
use Setono\TagBag\Tag\RenderedTag;

interface SerializerInterface
{
    /**
     * @param array<string, list<RenderedTag>> $tags
     *
     * @throws SerializationException if the serialization fails
     */
    public function serialize(array $tags): string;

    /**
     * @return array<string, list<RenderedTag>>
     *
     * @throws SerializationException if the deserialization fails
     */
    public function deserialize(string $data): array;
}
