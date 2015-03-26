<?php

namespace FnMock;

class PHPUnitTraitTest extends \PHPUnit_Framework_TestCase
{
    use PHPUnitTrait;

    public function testMockFunction()
    {
        $this->mockFunction('FnMock\str_replace', function($string) {
            return 'hassomespaces';
        });

        $this->assertEquals(stripSpaces('has some spaces'), 'hassomespaces');
    }
}

function stripSpaces($string)
{
    return str_replace(' ', '', $string);
}
