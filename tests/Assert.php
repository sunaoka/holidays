<?php

namespace Sunaoka\Holidays\Tests;

/**
 * @mixin \PHPUnit\Framework\TestCase
 */
trait Assert
{
    /**
     * @param string $exception
     */
    public function expectExceptionCompat($exception)
    {
        if (method_exists($this, 'expectException')) {
            $this->expectException($exception);
            return;
        }

        if (method_exists($this, 'setExpectedException')) {
            $this->setExpectedException($exception);
            return;
        }

        $this->fail('Assertion not found');
    }

    public function assertIsArrayCompat($actual, $message = '')
    {
        if (method_exists($this, 'assertIsArray')) {
            $this->assertIsArray($actual, $message);
            return;
        }

        $constraint = self::isType('array');

        self::assertThat($actual, $constraint, $message);

    }
}
