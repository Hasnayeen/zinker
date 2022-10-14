<?php

namespace App\Commands;

use InvalidArgumentException;
use Symfony\Component\Process\ExecutableFinder;

class Tinker
{
    public function __construct(
        public readonly array $args = [],
        public readonly null|string $executable = null,
    ) {
    }

    public function toArgs(): array
    {
        $executable = (new ExecutableFinder())->find(
            name: $this->executable ?? 'php',
        );

        if (null === $executable) {
            throw new InvalidArgumentException(
                message: "Cannot find executable for [$this->executable].",
            );
        }

        return array_merge(
            [$executable],
            $this->args,
        );
    }
}
