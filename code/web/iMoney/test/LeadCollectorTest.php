<?php



namespace Application\src\Tests;

use Application\src\LeadCollector;

class LeadCollectorTest extends \PHPUnit_Framework_TestCase
{
    protected $database;
    protected $resque;
    protected $handler;

    public function setUp()
    {
        $this->database = $this->getMock('Application\src\Database', array('query', 'beginTransaction', 'bind', 'execute', 'endTransaction'));
        $this->handler = new LeadCollector();
        $this->handler->setDatabase($this->database);

        $this->resque = $this->getMock('ResqueFake', array('size', 'push', 'pop'));
        $this->handler->setResque($this->resque);
    }

    public function testSaveWithInvalidData()
    {
        $input = array();

        $this->assertFalse($this->handler->save($input)); // Check te return value
    }

    public function testSaveWithCorrectData()
    {
        $input = array(
                array(
                'name' => 'name',
                'mobno' => 'mobno',
                'email' => 'email'
                ),
            );

        $this->database
                ->expects($this->exactly(4))->method('bind')->withAnyParameters();

        $this->database
                ->expects($this->at(2))
                ->method('bind')
                ->with(':name', 'name')
            ;

        $this->database
                ->expects($this->once())
                ->method('query')
            ;
        $this->assertNull($this->handler->save($input)); // Check te return value
    }

    public function testCreateNewJobStackWithIncorrentData()
    {
        $this->resque->expects($this->once())->method('size')->with('sample-jobstack')->will($this->returnValue('1'));
        $incorrect_data = array();

        $this->assertFalse($this->handler->createJobStack($incorrect_data, 'sample'));
    }

    public function testCreateNewJobStackWithCorrentData()
    {
        $this->resque->expects($this->once())->method('size')->with('sample-jobstack')->will($this->returnValue('1'));
        $correct_data = array(
                'name' => 'name',
                'mobno' => 'mobno',
                'email' => 'email',
                );

        $this->assertTrue($this->handler->createJobStack($correct_data, 'sample'));
    }

    public function testSizeOfStackIsBigEnoughToPush()
    {
        $mockHandler = $this->getMock('\Application\src\LeadCollector', array('save'));
        $mockHandler->expects($this->once())->method('save')->will($this->returnValue(true));

        $mock_resque = $this->getMock('SomeClass', array('size', 'push', 'pop'));
        $mockHandler->setResque($mock_resque);

        $mock_resque->expects($this->once())->method('size')->with('sample-jobstack')->will($this->returnValue(\Application\src\Config::$minQueueSize));
        $correct_data = array(
                'name' => 'name',
                'mobno' => 'mobno',
                'email' => 'email',
            );

        $mock_resque
                ->expects($this->exactly(\Application\src\Config::$minQueueSize))->method('pop')->withAnyParameters()->will($this->returnValue(true));

        $this->assertTrue($mockHandler->createJobStack($correct_data, 'sample'));
    }
}
