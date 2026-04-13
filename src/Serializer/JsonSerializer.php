<?php

declare(strict_types=1);

namespace Setono\TagBag\Serializer;

use JsonException;
use Setono\TagBag\Exception\SerializationException;
use Setono\TagBag\Tag\RenderedTag;
use Throwable;
use Webmozart\Assert\Assert;

final class JsonSerializer implements SerializerInterface
{
    public function serialize(array $tags): string
    {
        try {
            return json_encode($tags, \JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new SerializationException(message: $e->getMessage(), previous: $e);
        }
    }

    public function deserialize(string $data): array
    {
        try {
            /** @var mixed $data */
            $data = json_decode(json: $data, associative: true, flags: \JSON_THROW_ON_ERROR);
            Assert::isArray($data);

            $tags = [];

            foreach ($data as $section => $sectionTags) {
                Assert::string($section);
                Assert::isArray($sectionTags);

                /** @var mixed $tag */
                foreach ($sectionTags as $tag) {
                    Assert::isArray($tag);

                    /** @var array<string, mixed> $tagData */
                    $tagData = $tag;
                    $tags[$section][] = RenderedTag::createFromArray($tagData);
                }
            }

            return $tags;
        } catch (Throwable $e) {
            throw new SerializationException(message: $e->getMessage(), previous: $e);
        }
    }
}
