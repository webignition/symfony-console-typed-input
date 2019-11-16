<?php

declare(strict_types=1);

namespace webignition\SymfonyConsole\TypedInput;

use Symfony\Component\Console\Input\InputInterface;

class TypedInput extends InputProxy implements InputInterface
{
    public function __construct(InputInterface $input)
    {
        parent::__construct($input);

        if ($input instanceof TypedInput) {
            throw new \InvalidArgumentException('Wrapped InputInterface cannot be a TypedInput');
        }
    }

    public function getIntegerArgument(string $name, ?int $default = null): int
    {
        return $this->getIntegerValue(
            $this->getArgument($name),
            $default
        );
    }

    public function getBooleanArgument(string $name): ?bool
    {
        return $this->getBooleanValue($this->getArgument($name));
    }

    public function getIntegerOption(string $name, ?int $default = null): int
    {
        return $this->getIntegerValue(
            $this->getOption($name),
            $default
        );
    }

    public function getBooleanOption(string $name): ?bool
    {
        return $this->getBooleanValue($this->getOption($name));
    }

    public function getStringArgument(string $name, ?string $default = null): ?string
    {
        return $this->getStringValue(
            $this->getArgument($name),
            $default
        );
    }

    public function getStringOption(string $name, ?string $default = null): ?string
    {
        return $this->getStringValue(
            $this->getOption($name),
            $default
        );
    }

    private function getIntegerValue($value, int $default = null): int
    {
        if (!is_int($value) && !ctype_digit($value) && null !== $default) {
            return $default;
        }

        if (is_array($value)) {
            return (int) !empty($value);
        }

        return (int) $value;
    }

    private function getBooleanValue($value): ?bool
    {
        if (is_array($value)) {
            return !empty($value);
        }

        return (bool) $value;
    }

    private function getStringValue($value, ?string $default = null): ?string
    {
        return is_int($value) || is_string($value)
            ? (string) $value
            : $default;
    }
}
