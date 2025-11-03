<?php

declare(strict_types=1);

namespace webignition\SymfonyConsole\TypedInput;

use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

class InputProxy implements InputInterface
{
    private InputInterface $input;

    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    public function __toString(): string
    {
        return $this->input->__toString();
    }

    public function getFirstArgument(): ?string
    {
        return $this->input->getFirstArgument();
    }

    /**
     * @param array<mixed>|string $values
     */
    public function hasParameterOption(array|string $values, bool $onlyParams = false): bool
    {
        return $this->input->hasParameterOption($values, $onlyParams);
    }

    /**
     * @param array<mixed>|string                     $values
     * @param null|array<mixed>|bool|float|int|string $default
     */
    public function getParameterOption(
        array|string $values,
        array|bool|float|int|string|null $default = false,
        bool $onlyParams = false
    ): mixed {
        return $this->input->getParameterOption($values, $default, $onlyParams);
    }

    public function bind(InputDefinition $definition): void
    {
        $this->input->bind($definition);
    }

    public function validate(): void
    {
        $this->input->validate();
    }

    /**
     * @return array<mixed>
     */
    public function getArguments(): array
    {
        return $this->input->getArguments();
    }

    public function getArgument(string $name): mixed
    {
        return $this->input->getArgument($name);
    }

    /**
     * @param null|string|string[] $value
     */
    public function setArgument(string $name, $value): void
    {
        $this->input->setArgument($name, $value);
    }

    public function hasArgument(string $name): bool
    {
        return $this->input->hasArgument($name);
    }

    /**
     * @return array<mixed>
     */
    public function getOptions(): array
    {
        return $this->input->getOptions();
    }

    public function getOption(string $name): mixed
    {
        return $this->input->getOption($name);
    }

    public function setOption(string $name, mixed $value): void
    {
        $this->input->setOption($name, $value);
    }

    public function hasOption(string $name): bool
    {
        return $this->input->hasOption($name);
    }

    public function isInteractive(): bool
    {
        return $this->input->isInteractive();
    }

    public function setInteractive(bool $interactive): void
    {
        $this->input->setInteractive($interactive);
    }
}
