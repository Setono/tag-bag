<?php

declare(strict_types=1);

namespace Setono\TagBag\Serializer;

use Setono\TagBag\Exception\SerializationException;
use Setono\TagBag\Tag\RenderedTag;
use Webmozart\Assert\Assert;

/**
 * @deprecated since 2.3 and will be removed in 3.0. Use the `JsonSerializer` instead
 */
final class PhpSerializer implements SerializerInterface
{
    public function serialize(array $tags): string
    {
        return serialize($tags);
    }

    /**
     * Most of this method is taken from here: https://github.com/symfony/symfony/blob/6.2/src/Symfony/Component/Messenger/Transport/Serialization/PhpSerializer.php
     */
    public function deserialize(string $data): array
    {
        if ('' === $data) {
            throw SerializationException::emptyData();
        }

        $serializationException = new SerializationException(sprintf('Could not unserialize data: %s.', $data));
        $prevUnserializeHandler = ini_set('unserialize_callback_func', self::class . '::handleUnserializeCallback');
        /** @psalm-suppress MixedArgumentTypeCoercion,UndefinedVariable */
        $prevErrorHandler = set_error_handler(static function (int $type, string $msg, string $file, int $line) use (&$prevErrorHandler, $serializationException): bool {
            if (__FILE__ === $file) {
                throw $serializationException;
            }

            if (null !== $prevErrorHandler) {
                return (bool) $prevErrorHandler($type, $msg, $file, $line);
            }

            return false;
        });

        try {
            $result = unserialize($data, [
                'allowed_classes' => [RenderedTag::class],
            ]);

            if (!is_array($result)) {
                throw new \InvalidArgumentException('Expected array');
            }

            /** @var array<string, list<RenderedTag>> $validated */
            $validated = [];
            foreach ($result as $section => $tags) {
                Assert::string($section);
                Assert::isArray($tags);
                Assert::allIsInstanceOf($tags, RenderedTag::class);

                /** @var list<RenderedTag> $sectionTags */
                $sectionTags = $tags;
                $validated[$section] = $sectionTags;
            }
        } catch (\InvalidArgumentException) {
            throw new SerializationException(sprintf('The unserialized data was incorrect. Here is the original data: %s', $data));
        } finally {
            restore_error_handler();
            ini_set('unserialize_callback_func', $prevUnserializeHandler);
        }

        return $validated;
    }

    /**
     * @internal
     */
    public static function handleUnserializeCallback(string $class): never
    {
        throw new SerializationException(sprintf('Message class "%s" not found during decoding.', $class));
    }
}
