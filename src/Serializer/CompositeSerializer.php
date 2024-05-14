<?php

declare(strict_types=1);

namespace Setono\TagBag\Serializer;

use Setono\TagBag\Exception\SerializationException;

final class CompositeSerializer implements SerializerInterface
{
    /** @var list<SerializerInterface> */
    private array $serializers = [];

    public function __construct(SerializerInterface ...$serializers)
    {
        foreach ($serializers as $serializer) {
            $this->add($serializer);
        }
    }

    public function add(SerializerInterface $serializer): void
    {
        $this->serializers[] = $serializer;
    }

    public function serialize(array $tags): string
    {
        foreach ($this->serializers as $serializer) {
            try {
                return $serializer->serialize($tags);
            } catch (SerializationException) {
                continue;
            }
        }

        throw new SerializationException('No serializer was able to serialize the tags');
    }

    public function deserialize(string $data): array
    {
        foreach ($this->serializers as $serializer) {
            try {
                return $serializer->deserialize($data);
            } catch (SerializationException) {
                continue;
            }
        }

        throw new SerializationException('No serializer was able to deserialize the data');
    }
}
