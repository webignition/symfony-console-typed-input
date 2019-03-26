<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\SymfonyConsole\TypedInput\Tests;

use Mockery\MockInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
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
}
