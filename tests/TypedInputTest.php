<?php
/** @noinspection PhpDocSignatureInspection */

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
    public function testGetIntegerArgument($source, int $expectedValue)
    {
        $this->assertGetIntegerValue(
            'getArgument',
            $source,
            $expectedValue,
            function (TypedInput $typedInput) {
                return $typedInput->getIntegerArgument('name');
            }
        );
    }

    /**
     * @dataProvider getIntegerValueDataProvider
     */
    public function testGetIntegerOption($source, int $expectedValue)
    {
        $this->assertGetIntegerValue(
            'getOption',
            $source,
            $expectedValue,
            function (TypedInput $typedInput) {
                return $typedInput->getIntegerOption('name');
            }
        );
    }

    private function assertGetIntegerValue(string $mockedMethodName, $source, int $expectedValue, callable $valueGetter)
    {
        $name = 'name';

        $input = \Mockery::mock(InputInterface::class);
        $input
            ->shouldReceive($mockedMethodName)
            ->with($name)
            ->andReturn($source);

        $typedInput = new TypedInput($input);

        $value = $valueGetter($typedInput);

        $this->assertIsInt($value);
        $this->assertEquals($expectedValue, $value);
    }

    public function getIntegerValueDataProvider(): array
    {
        return [
            'int' => [
                'source' => 100,
                'expectedValue' => 100,
            ],
            'integer string' => [
                'source' => (string) 99,
                'expectedValue' => 99,
            ],
            'non-integer string' => [
                'source' => 'string',
                'expectedValue' => 0,
            ],
            'empty array' => [
                'source' => [],
                'expectedValue' => 0,
            ],
            'non-empty array' => [
                'source' => [1],
                'expectedValue' => 1,
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
