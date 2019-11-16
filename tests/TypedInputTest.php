<?php

declare(strict_types=1);

namespace webignition\SymfonyConsole\TypedInput\Tests;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use webignition\SymfonyConsole\TypedInput\TypedInput;

class TypedInputTest extends \PHPUnit\Framework\TestCase
{
    public function testWrapTypedInput()
    {
        $arrayInput = new ArrayInput([]);
        $typedInput = new TypedInput($arrayInput);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Wrapped InputInterface cannot be a TypedInput');

        new TypedInput($typedInput);
    }

    /**
     * @dataProvider getIntegerValueDataProvider
     */
    public function testGetIntegerArgument($source, ?int $default, int $expectedValue)
    {
        $this->assertGetIntegerValue(
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
     * @dataProvider getIntegerValueDataProvider
     */
    public function testGetIntegerOption($source, ?int $default, $expectedValue)
    {
        $this->assertGetIntegerValue(
            'getOption',
            $source,
            $default,
            $expectedValue,
            function (TypedInput $typedInput, ?int $default) {
                return $typedInput->getIntegerOption('name', $default);
            }
        );
    }

    private function assertGetIntegerValue(
        string $mockedMethodName,
        $source,
        ?int $default,
        int $expectedValue,
        callable $valueGetter
    ) {
        $name = 'name';

        $input = \Mockery::mock(InputInterface::class);
        $input
            ->shouldReceive($mockedMethodName)
            ->with($name)
            ->andReturn($source);

        $typedInput = new TypedInput($input);

        $value = $valueGetter($typedInput, $default);

        $this->assertIsInt($value);
        $this->assertEquals($expectedValue, $value);
    }

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
     * @dataProvider getBooleanValueDataProvider
     */
    public function testGetBooleanArgument($source, bool $expectedValue)
    {
        $this->assertGetBooleanValue(
            'getArgument',
            $source,
            $expectedValue,
            function (TypedInput $typedInput) {
                return $typedInput->getBooleanArgument('name');
            }
        );
    }

    /**
     * @dataProvider getBooleanValueDataProvider
     */
    public function testGetBooleanOption($source, bool $expectedValue)
    {
        $this->assertGetBooleanValue(
            'getOption',
            $source,
            $expectedValue,
            function (TypedInput $typedInput) {
                return $typedInput->getBooleanOption('name');
            }
        );
    }

    private function assertGetBooleanValue(
        string $mockedMethodName,
        $source,
        bool $expectedValue,
        callable $valueGetter
    ) {
        $name = 'name';

        $input = \Mockery::mock(InputInterface::class);
        $input
            ->shouldReceive($mockedMethodName)
            ->with($name)
            ->andReturn($source);

        $typedInput = new TypedInput($input);

        $value = $valueGetter($typedInput);

        $this->assertIsBool($value);
        $this->assertEquals($expectedValue, $value);
    }

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
}
