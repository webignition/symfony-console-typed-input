# Symfony Console Typed Input

A wrapper for `Symfony\Component\Console\Input\InputInterface` adding integer- and boolean-specific
argument and option getters.

For fans of strongly-typed PHP, or just those tired of battling with [phpstan](https://github.com/phpstan/phpstan)
`--level max` when analysing Symfony console commands.

## Methods
```php
public function getIntegerArgument(string $name): int;
public function getIntegerOption(string $name): int;
public function getBooleanArgument(string $name): bool;
public function getBooleanOption(string $name): bool;
```

All other `InputInterface` method calls are proxied to the wrapped `InputInterface` instance.

## Usage

```php
use webignition\SymfonyConsole\TypedInput\TypedInput;

// Assuming we're in a console command and $input is an InputInterface instance

$typedInput = new TypedInput($input);

// Guaranteed to return an integer
$integerArgument = $typedInput->getIntegerArgument('integer-argument-name');
$integerOption = $typedInput->getIntegerOption('integer-option-name');

// Guaranteed to return a boolean
$booleanArgument = $typedInput->getBooleanArgument('boolean-argument-name');
$booleanOption = $typedInput->getBooleanOption('boolean-option-name');
