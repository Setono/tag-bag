<?php

declare(strict_types=1);

namespace Setono\TagBag\Generator;

use Setono\TagBag\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class ValueBasedFingerprintGenerator implements FingerprintGeneratorInterface
{
    /** @var string */
    private $hashAlgorithm;

    public function __construct(string $hashAlgorithm = 'md5')
    {
        Assert::oneOf($hashAlgorithm, hash_algos());

        $this->hashAlgorithm = $hashAlgorithm;
    }

    public function generate(TagInterface $tag, string $renderedValue): string
    {
        return hash($this->hashAlgorithm, $renderedValue);
    }
}
