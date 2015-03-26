<?php

namespace FnMock;

trait PHPUnitTrait
{
    protected function mockFunction($fn, callable $callback)
    {
        FnMock::mock($fn, $callback);
    }

    public function tearDown()
    {
        FnMock::reset();
        parent::tearDown();
    }
}
