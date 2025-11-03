<?php

declare(strict_types=1);

namespace webignition\SymfonyConsole\TypedInput\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use webignition\SymfonyConsole\TypedInput\TypedInput;

class TypedInputTest extends TestCase
{
    public function testWrapTypedInput(): void
    {
        $arrayInput = new ArrayInput([]);
        $typedInput = new TypedInput($arrayInput);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Wrapped InputInterface cannot be a TypedInput');

        new TypedInput($typedInput);
    }

    /**
     * @param mixed $source
     *
     * @dataProvider getIntegerValueDataProvider
     */
    public function testGetIntegerArgument($source, ?int $default, int $expectedValue): void
    {
        $this->assertGetValue(
            'getArgument',
            $source,
            $default,
            $expectedValue,
            function (TypedInput $typedInput, ?int $default) {
                return $typedInput->getIntegerArgument('name', $default);
            }
        );
    }

    /**
     * @param mixed $source
     *
     * @dataProvider getIntegerValueDataProvider
     */
    public function testGetIntegerOption($source, ?int $default, int $expectedValue): void
    {
        $this->assertGetValue(
            'getOption',
            $source,
            $default,
            $expectedValue,
            function (TypedInput $typedInput, $default) {
                return $typedInput->getIntegerOption('name', $default);
            }
        );
    }

    /**
     * @return array<mixed>
     */
    public function getIntegerValueDataProvider(): array
    {
        return [
            'int' => [
                'source' => 100,
                'default' => null,
                'expectedValue' => 100,
            ],
            'integer string' => [
                'source' => (string) 99,
                'default' => null,
                'expectedValue' => 99,
            ],
            'non-integer string, no default' => [
                'source' => 'string',
                'default' => null,
                'expectedValue' => 0,
            ],
            'empty array, no default' => [
                'source' => [],
                'default' => null,
                'expectedValue' => 0,
            ],
            'non-empty array, no default' => [
                'source' => [1],
                'default' => null,
                'expectedValue' => 1,
            ],
            'non-integer string, has default' => [
                'source' => 'string',
                'default' => 50,
                'expectedValue' => 50,
            ],
            'empty array, has default' => [
                'source' => [],
                'default' => 51,
                'expectedValue' => 51,
            ],
            'non-empty array, has default' => [
                'source' => [1],
                'default' => 52,
                'expectedValue' => 52,
            ],
        ];
    }

    /**
     * @param mixed $source
     *
     * @dataProvider getBooleanValueDataProvider
     */
    public function testGetBooleanArgument($source, bool $expectedValue): void
    {
        $this->assertGetValue(
            'getArgument',
            $source,
            null,
            $expectedValue,
            function (TypedInput $typedInput) {
                return $typedInput->getBooleanArgument('name');
            }
        );
    }

    /**
     * @param mixed $source
     *
     * @dataProvider getBooleanValueDataProvider
     */
    public function testGetBooleanOption($source, bool $expectedValue): void
    {
        $this->assertGetValue(
            'getOption',
            $source,
            null,
            $expectedValue,
            function (TypedInput $typedInput) {
                return $typedInput->getBooleanOption('name');
            }
        );
    }

    /**
     * @return array<mixed>
     */
    public function getBooleanValueDataProvider(): array
    {
        return [
            'empty array' => [
                'source' => [],
                'expectedValue' => false,
            ],
            'non-empty array' => [
                'source' => [1],
                'expectedValue' => true,
            ],
            'string "0"' => [
                'source' => '0',
                'expectedValue' => false,
            ],
            'string "1"' => [
                'source' => '1',
                'expectedValue' => true,
            ],
            'string "100"' => [
                'source' => '100',
                'expectedValue' => true,
            ],
        ];
    }

    /**
     * @param mixed $source
     *
     * @dataProvider getStringValueDataProvider
     */
    public function testGetStringArgument($source, ?string $default, ?string $expectedValue): void
    {
        $this->assertGetValue(
            'getArgument',
            $source,
            $default,
            $expectedValue,
            function (TypedInput $typedInput, $default) {
                return $typedInput->getStringArgument('name', $default);
            }
        );
    }

    /**
     * @param mixed $source
     *
     * @dataProvider getStringValueDataProvider
     */
    public function testGetStringOption($source, ?string $default, ?string $expectedValue): void
    {
        $this->assertGetValue(
            'getOption',
            $source,
            $default,
            $expectedValue,
            function (TypedInput $typedInput, $default) {
                return $typedInput->getStringOption('name', $default);
            }
        );
    }

    /**
     * @return array<mixed>
     */
    public function getStringValueDataProvider(): array
    {
        return [
            'int' => [
                'source' => 100,
                'default' => null,
                'expectedValue' => '100',
            ],
            'integer string' => [
                'source' => '99',
                'default' => null,
                'expectedValue' => '99',
            ],
            'string, no default' => [
                'source' => 'string',
                'default' => null,
                'expectedValue' => 'string',
            ],
            'empty array, no default' => [
                'source' => [],
                'default' => null,
                'expectedValue' => null,
            ],
            'non-empty array, no default' => [
                'source' => [1],
                'default' => null,
                'expectedValue' => null,
            ],
            'string, has default' => [
                'source' => 'string',
                'default' => 'default',
                'expectedValue' => 'string',
            ],
            'empty array, has default' => [
                'source' => [],
                'default' => 'default',
                'expectedValue' => 'default',
            ],
            'non-empty array, has default' => [
                'source' => [1],
                'default' => 'default',
                'expectedValue' => 'default',
            ],
        ];
    }

    /**
     * @param mixed $source
     * @param mixed $default
     * @param mixed $expectedValue
     */
    private function assertGetValue(
        string $mockedMethodName,
        $source,
        $default,
        $expectedValue,
        callable $valueGetter
    ): void {
        $name = 'name';

        $input = \Mockery::mock(InputInterface::class);
        $input
            ->shouldReceive($mockedMethodName)
            ->with($name)
            ->andReturn($source)
        ;

        $typedInput = new TypedInput($input);

        $value = $valueGetter($typedInput, $default);

        $this->assertSame($expectedValue, $value);
    }
}
