<?php

declare(strict_types=1);

namespace webignition\SymfonyConsole\TypedInput\Tests;

use Mockery\MockInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use webignition\SymfonyConsole\TypedInput\TypedInput;

class TypedInputProxyTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var InputInterface|MockInterface
     */
    private $sourceInput;

    /**
     * @var TypedInput
     */
    private $typedInput;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sourceInput = \Mockery::mock(InputInterface::class);
        $this->typedInput = new TypedInput($this->sourceInput);
    }

    public function testGetFirstArgument()
    {
        $firstArgument = 'first argument';

        $this->sourceInput
            ->shouldReceive('getFirstArgument')
            ->withNoArgs()
            ->andReturn($firstArgument);

        $this->assertEquals($firstArgument, $this->typedInput->getFirstArgument());
    }

    public function testHasParameterOption()
    {
        $values = 'values';
        $onlyParams = false;
        $hasParameterOption = true;

        $this->sourceInput
            ->shouldReceive('hasParameterOption')
            ->with($values, $onlyParams)
            ->andReturn($hasParameterOption);

        $this->assertEquals($hasParameterOption, $this->typedInput->hasParameterOption($values, $onlyParams));
    }

    public function testGetParameterOption()
    {
        $values = 'values';
        $default = false;
        $onlyParams = false;
        $option = 'option';

        $this->sourceInput
            ->shouldReceive('getParameterOption')
            ->with($values, $default, $onlyParams)
            ->andReturn($option);

        $this->assertEquals($option, $this->typedInput->getParameterOption($values, $default, $onlyParams));
    }

    public function testBind()
    {
        $inputDefinition = \Mockery::mock(InputDefinition::class);

        $this->sourceInput
            ->shouldReceive('bind')
            ->with($inputDefinition);

        $this->typedInput->bind($inputDefinition);
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testValidate()
    {
        $this->sourceInput
            ->shouldReceive('validate');

        $this->typedInput->validate();
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testGetArguments()
    {
        $arguments = [];

        $this->sourceInput
            ->shouldReceive('getArguments')
            ->andReturn($arguments);

        $this->assertEquals($arguments, $this->typedInput->getArguments());
    }

    public function testGetArgument()
    {
        $name = 'argument';
        $value = 'value';

        $this->sourceInput
            ->shouldReceive('getArgument')
            ->with($name)
            ->andReturn($value);

        $this->assertEquals($value, $this->typedInput->getArgument($name));
    }

    public function testSetArgument()
    {
        $name = 'name';
        $value = 'value';

        $this->sourceInput
            ->shouldReceive('setArgument')
            ->with($name, $value);

        $this->typedInput->setArgument($name, $value);
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testHasArgument()
    {
        $name = 'argument';
        $hasArgument = true;

        $this->sourceInput
            ->shouldReceive('hasArgument')
            ->with($name)
            ->andReturn($hasArgument);

        $this->assertEquals($hasArgument, $this->typedInput->hasArgument($name));
    }

    public function testGetOptions()
    {
        $options = [];

        $this->sourceInput
            ->shouldReceive('getOptions')
            ->andReturn($options);

        $this->assertEquals($options, $this->typedInput->getOptions());
    }

    public function testGetOption()
    {
        $name = 'argument';
        $value = 'value';

        $this->sourceInput
            ->shouldReceive('getOption')
            ->with($name)
            ->andReturn($value);

        $this->assertEquals($value, $this->typedInput->getOption($name));
    }

    public function testSetOption()
    {
        $name = 'name';
        $value = 'value';

        $this->sourceInput
            ->shouldReceive('setOption')
            ->with($name, $value);

        $this->typedInput->setOption($name, $value);
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testHasOption()
    {
        $name = 'option';
        $hasOption = true;

        $this->sourceInput
            ->shouldReceive('hasOption')
            ->with($name)
            ->andReturn($hasOption);

        $this->assertEquals($hasOption, $this->typedInput->hasOption($name));
    }

    public function testIsInteractive()
    {
        $isInteractive = true;

        $this->sourceInput
            ->shouldReceive('isInteractive')
            ->andReturn($isInteractive);

        $this->assertEquals($isInteractive, $this->typedInput->isInteractive());
    }

    public function testSetInteractive()
    {
        $interactive = true;

        $this->sourceInput
            ->shouldReceive('setInteractive')
            ->with($interactive);

        $this->typedInput->setInteractive($interactive);
        $this->addToAssertionCount(\Mockery::getContainer()->mockery_getExpectationCount());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        \Mockery::close();
    }
}
