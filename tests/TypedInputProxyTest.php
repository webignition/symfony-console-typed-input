<?php

declare(strict_types=1);

namespace webignition\SymfonyConsole\TypedInput\Tests;

use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use webignition\SymfonyConsole\TypedInput\TypedInput;

class TypedInputProxyTest extends TestCase
{
    /**
     * @var InputInterface
     */
    private $sourceInput;
    private TypedInput $typedInput;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sourceInput = \Mockery::mock(InputInterface::class);
        $this->typedInput = new TypedInput($this->sourceInput);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        \Mockery::close();
    }

    public function testGetFirstArgument(): void
    {
        $firstArgument = 'first argument';

        $this->applyMockCalls(function (MockInterface $mock) use ($firstArgument) {
            $mock
                ->shouldReceive('getFirstArgument')
                ->withNoArgs()
                ->andReturn($firstArgument)
            ;
        });

        $this->assertEquals($firstArgument, $this->typedInput->getFirstArgument());
    }

    public function testHasParameterOption(): void
    {
        $values = 'values';
        $onlyParams = false;
        $hasParameterOption = true;

        $this->applyMockCalls(function (MockInterface $mock) use ($values, $onlyParams, $hasParameterOption) {
            $mock
                ->shouldReceive('hasParameterOption')
                ->with($values, $onlyParams)
                ->andReturn($hasParameterOption)
            ;
        });

        $this->assertEquals($hasParameterOption, $this->typedInput->hasParameterOption($values, $onlyParams));
    }

    public function testGetParameterOption(): void
    {
        $values = 'values';
        $default = false;
        $onlyParams = false;
        $option = 'option';

        $this->applyMockCalls(function (MockInterface $mock) use ($values, $default, $onlyParams, $option) {
            $mock
                ->shouldReceive('getParameterOption')
                ->with($values, $default, $onlyParams)
                ->andReturn($option)
            ;
        });

        $this->assertEquals($option, $this->typedInput->getParameterOption($values, $default, $onlyParams));
    }

    public function testBind(): void
    {
        $inputDefinition = \Mockery::mock(InputDefinition::class);

        $this->applyMockCalls(function (MockInterface $mock) use ($inputDefinition) {
            $mock
                ->shouldReceive('bind')
                ->with($inputDefinition)
            ;
        });

        $this->typedInput->bind($inputDefinition);
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testValidate(): void
    {
        $this->applyMockCalls(function (MockInterface $mock) {
            $mock
                ->shouldReceive('validate')
            ;
        });

        $this->typedInput->validate();
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testGetArguments(): void
    {
        $arguments = [];

        $this->applyMockCalls(function (MockInterface $mock) use ($arguments) {
            $mock
                ->shouldReceive('getArguments')
                ->andReturn($arguments)
            ;
        });

        $this->assertEquals($arguments, $this->typedInput->getArguments());
    }

    public function testGetArgument(): void
    {
        $name = 'argument';
        $value = 'value';

        $this->applyMockCalls(function (MockInterface $mock) use ($name, $value) {
            $mock
                ->shouldReceive('getArgument')
                ->with($name)
                ->andReturn($value)
            ;
        });

        $this->assertEquals($value, $this->typedInput->getArgument($name));
    }

    public function testSetArgument(): void
    {
        $name = 'name';
        $value = 'value';

        $this->applyMockCalls(function (MockInterface $mock) use ($name, $value) {
            $mock
                ->shouldReceive('setArgument')
                ->with($name, $value)
            ;
        });

        $this->typedInput->setArgument($name, $value);
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testHasArgument(): void
    {
        $name = 'argument';
        $hasArgument = true;

        $this->applyMockCalls(function (MockInterface $mock) use ($name, $hasArgument) {
            $mock
                ->shouldReceive('hasArgument')
                ->with($name)
                ->andReturn($hasArgument)
            ;
        });

        $this->assertEquals($hasArgument, $this->typedInput->hasArgument($name));
    }

    public function testGetOptions(): void
    {
        $options = [];

        $this->applyMockCalls(function (MockInterface $mock) use ($options) {
            $mock
                ->shouldReceive('getOptions')
                ->andReturn($options)
            ;
        });

        $this->assertEquals($options, $this->typedInput->getOptions());
    }

    public function testGetOption(): void
    {
        $name = 'argument';
        $value = 'value';

        $this->applyMockCalls(function (MockInterface $mock) use ($name, $value) {
            $mock
                ->shouldReceive('getOption')
                ->with($name)
                ->andReturn($value)
            ;
        });

        $this->assertEquals($value, $this->typedInput->getOption($name));
    }

    public function testSetOption(): void
    {
        $name = 'name';
        $value = 'value';

        $this->applyMockCalls(function (MockInterface $mock) use ($name, $value) {
            $mock
                ->shouldReceive('setOption')
                ->with($name, $value)
            ;
        });

        $this->typedInput->setOption($name, $value);
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testHasOption(): void
    {
        $name = 'option';
        $hasOption = true;

        $this->applyMockCalls(function (MockInterface $mock) use ($name, $hasOption) {
            $mock
                ->shouldReceive('hasOption')
                ->with($name)
                ->andReturn($hasOption)
            ;
        });

        $this->assertEquals($hasOption, $this->typedInput->hasOption($name));
    }

    public function testIsInteractive(): void
    {
        $isInteractive = true;

        $this->applyMockCalls(function (MockInterface $mock) use ($isInteractive) {
            $mock
                ->shouldReceive('isInteractive')
                ->andReturn($isInteractive)
            ;
        });

        $this->assertEquals($isInteractive, $this->typedInput->isInteractive());
    }

    public function testSetInteractive(): void
    {
        $interactive = true;

        $this->applyMockCalls(function (MockInterface $mock) use ($interactive) {
            $mock
                ->shouldReceive('setInteractive')
                ->with($interactive)
            ;
        });

        $this->typedInput->setInteractive($interactive);
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    private function applyMockCalls(callable $callable): void
    {
        if ($this->sourceInput instanceof MockInterface) {
            $callable($this->sourceInput);
        }
    }
}
