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

    public function getFirstArgument(): ?string
    {
        return $this->input->getFirstArgument();
    }

    /**
     * @param array<mixed>|string $values
     */
    public function hasParameterOption($values, bool $onlyParams = false): bool
    {
        return $this->input->hasParameterOption($values, $onlyParams);
    }

    /**
     * @param array<mixed>|string $values
     * @param mixed               $default
     */
    public function getParameterOption($values, $default = false, bool $onlyParams = false)
    {
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

    public function getArgument(string $name)
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

    /**
     * @param string|int $name
     */
    public function hasArgument($name): bool
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

    public function getOption(string $name)
    {
        return $this->input->getOption($name);
    }

    /**
     * @param null|bool|string|string[] $value
     */
    public function setOption(string $name, $value): void
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
