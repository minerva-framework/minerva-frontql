<?php

namespace Tests\FrontQL\Adapter\Where;

use Minerva\FrontQL\Adapter\Where\WhereAdapter;
use Zend\Db\Sql\Where;

class WhereAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testAdaptation()
    {
        $array = [
            'nest',
            ['isNotNull', 'email'],
            'and',
            ['isNotNull', 'name'],
            'unnest',
            'or',
            ['greaterThan', 'age', 18],
        ];

        $adapter = new WhereAdapter();
        $where = $adapter->fromArray($array);
        $this->assertTrue($where instanceof Where);
    }

    /**
     * @expectedException \Minerva\FrontQL\Adapter\Where\Basis\Exception\InvalidCommandException
     */
    public function testAdaptationWithInvalidCommand()
    {
        $array = [
            'nest',
            ['isNotNullXAXAXASA', 'email'],
            'and',
            ['isNotNull', 'name'],
            'unnest',
            'or',
            ['greaterThan', 'age', 18],
        ];

        $adapter = new WhereAdapter();
        $adapter->fromArray($array);
    }
}