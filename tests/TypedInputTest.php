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
     * @dataProvider getIntegerArgumentDataProvider
     */
    public function testGetIntegerArgument($source, int $expectedArgument)
    {
        $name = 'name';

        $input = \Mockery::mock(InputInterface::class);
        $input
            ->shouldReceive('getArgument')
            ->with($name)
            ->andReturn($source);

        $typedInput = new TypedInput($input);

        $argument = $typedInput->getIntegerArgument($name);

        $this->assertIsInt($argument);
        $this->assertEquals($expectedArgument, $argument);
    }

    public function getIntegerArgumentDataProvider(): array
    {
        return [
            'int' => [
                'source' => 100,
                'expectedArgument' => 100,
            ],
            'integer string' => [
                'source' => (string) 99,
                'expectedArgument' => 99,
            ],
            'non-integer string' => [
                'source' => 'string',
                'expectedArgument' => 0,
            ],
            'empty array' => [
                'source' => [],
                'expectedArgument' => 0,
            ],
            'non-empty array' => [
                'source' => [1],
                'expectedArgument' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getBooleanArgumentDataProvider
     */
    public function testGetBooleanArgument($source, bool $expectedArgument)
    {
        $name = 'name';

        $input = \Mockery::mock(InputInterface::class);
        $input
            ->shouldReceive('getArgument')
            ->with($name)
            ->andReturn($source);

        $typedInput = new TypedInput($input);

        $this->assertEquals($expectedArgument, $typedInput->getBooleanArgument($name));
    }

    public function getBooleanArgumentDataProvider(): array
    {
        return [
            'empty array' => [
                'source' => [],
                'expectedArgument' => false,
            ],
            'non-empty array' => [
                'source' => [1],
                'expectedArgument' => true,
            ],
            'string "0"' => [
                'source' => '0',
                'expectedArgument' => false,
            ],
            'string "1"' => [
                'source' => '1',
                'expectedArgument' => true,
            ],
            'string "100"' => [
                'source' => '100',
                'expectedArgument' => true,
            ],
        ];
    }
}
