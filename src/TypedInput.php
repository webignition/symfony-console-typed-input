<?php

namespace webignition\SymfonyConsole\TypedInput;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

class TypedInput implements InputInterface
{
    private $input;

    public function __construct(InputInterface $input)
    {
        if ($input instanceof TypedInput) {
            throw new \InvalidArgumentException('Wrapped InputInterface cannot be a TypedInput');
        }

        $this->input = $input;
    }

    public function getFirstArgument(): ?string
    {
        return $this->input->getFirstArgument();
    }

    /**
     * @param string|array $values The values to look for in the raw parameters (can be an array)
     * @param bool $onlyParams Only check real parameters, skip those following an end of options (--) signal
     *
     * @return bool true if the value is contained in the raw parameters
     */
    public function hasParameterOption($values, $onlyParams = false): bool
    {
        return $this->input->hasParameterOption($values, $onlyParams);
    }

    /**
     * @param string|array $values The value(s) to look for in the raw parameters (can be an array)
     * @param mixed $default The default value to return if no result is found
     * @param bool $onlyParams Only check real parameters, skip those following an end of options (--) signal
     *
     * @return mixed The option value
     */
    public function getParameterOption($values, $default = false, $onlyParams = false)
    {
        return $this->input->getParameterOption($values, $default, $onlyParams);
    }

    /**
     * @param InputDefinition $definition
     * @throws RuntimeException
     */
    public function bind(InputDefinition $definition)
    {
        $this->input->bind($definition);
    }

    /**
     * @throws RuntimeException When not enough arguments are given
     */
    public function validate()
    {
        $this->input->validate();
    }

    public function getArguments(): array
    {
        return $this->input->getArguments();
    }

    /**
     * @param string $name The argument name
     *
     * @return string|string[]|null The argument value
     *
     * @throws InvalidArgumentException When argument given doesn't exist
     */
    public function getArgument($name)
    {
        return $this->input->getArgument($name);
    }

    public function getIntegerArgument(string $name, int $default = null): int
    {
        return $this->getIntegerValue(
            $this->getArgument($name),
            $default
        );
    }

    public function getBooleanArgument(string $name): ?bool
    {
        $argument = $this->getArgument($name);

        if (is_array($argument)) {
            return !empty($argument);
        }

        return (bool) $argument;
    }

    /**
     * @param string $name The argument name
     * @param string|string[]|null $value The argument value
     *
     * @throws InvalidArgumentException When argument given doesn't exist
     */
    public function setArgument($name, $value)
    {
        $this->input->setArgument($name, $value);
    }

    /**
     * @param string|int $name The InputArgument name or position
     *
     * @return bool true if the InputArgument object exists, false otherwise
     */
    public function hasArgument($name): bool
    {
        return $this->input->hasArgument($name);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->input->getOptions();
    }

    /**
     * @param string $name The option name
     *
     * @return string|string[]|bool|null The option value
     *
     * @throws InvalidArgumentException When option given doesn't exist
     */
    public function getOption($name)
    {
        return $this->input->getOption($name);
    }

    public function getIntegerOption(string $name, int $default = null): int
    {
        return $this->getIntegerValue(
            $this->getOption($name),
            $default
        );
    }

    public function getBooleanOption(string $name): ?bool
    {
        $option = $this->getOption($name);

        if (is_array($option)) {
            return !empty($option);
        }

        return (bool) $option;
    }


    /**
     * @param string $name The option name
     * @param string|string[]|bool|null $value The option value
     *
     * @throws InvalidArgumentException When option given doesn't exist
     */
    public function setOption($name, $value)
    {
        return $this->input->setOption($name, $value);
    }

    /**
     * @param string $name The InputOption name
     *
     * @return bool true if the InputOption object exists, false otherwise
     */
    public function hasOption($name): bool
    {
        return $this->input->hasOption($name);
    }

    /**
     * @return bool
     */
    public function isInteractive(): bool
    {
        return $this->input->isInteractive();
    }

    /**
     * @param bool $interactive If the input should be interactive
     */
    public function setInteractive($interactive)
    {
        $this->input->setInteractive($interactive);
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
}
