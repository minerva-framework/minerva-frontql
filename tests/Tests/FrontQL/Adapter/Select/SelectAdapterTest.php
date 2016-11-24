<?php

namespace Tests\FrontQL\Adapter\Select;

use Minerva\FrontQL\Adapter\Select\SelectAdapter;
use Minerva\FrontQL\Adapter\Select\SelectPayload;
use Zend\Db\Sql\Select;

class SelectAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testAdaptation()
    {
        $where = [
            'nest',
            ['isNotNull', 'email'],
            'and',
            ['isNotNull', 'name'],
            'unnest',
            'or',
            ['greaterThan', 'age', 18],
        ];

        $payload = [
            'columns' => ['name', 'age', 'email' ],
            'where'   => $where,
            'limit'   => 20,
            'order'   => [[['name', 'idade'], 'ASC'], [['email'], 'DESC']]
        ];

        $adapter = new SelectAdapter();
        $adapter->setProtectedColumns(['name']);
        $adapter->setSelectPayload(new SelectPayload($payload));
        $select = $adapter->getSelect();

        $this->assertTrue($select instanceof Select);
        $this->assertEquals($select->getRawState($select::LIMIT), 20);
        $this->assertCount(2, $select->getRawState($select::COLUMNS));
        $this->assertCount(5, $select->getRawState($select::ORDER));
    }
}