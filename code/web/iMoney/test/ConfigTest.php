<?php



namespace Application\src\Tests;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function configStaticAttrs()
    {
        return [
                ['minQueueSize'],
                ['dbDetails'],
                ['validKeys'],
            ];
    }

    /**
     * @dataProvider configStaticAttrs
     */
    public function testStaticPropertyExistance($attr)
    {
        $this->assertClassHasStaticAttribute($attr, '\Application\src\Config');
    }
}
