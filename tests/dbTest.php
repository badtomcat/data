<?php


use Badtomcat\Db\Connection\MysqlPdoConn;

class Test extends PHPUnit_Framework_TestCase {
    /**
     * @var MysqlPdoConn
     */
    private $con;
    public function setUp()
    {
        $this->con = new MysqlPdoConn([
	         	'host' => "127.0.0.1",
	         	'port' => "3306",
	         	'database' => "tpv3",
	         	'user' => "root",
           	    'password' => "root",
            	'charset' => "utf8"
            	]);

    }

    public function tearDown()
    {

    }

    public function testToArr()
    {
        $f = new \Badtomcat\Data\Mysql\Field();
        $f->setName("foo");
        $f->setDataType_enum();
        $f->setDomain(['foo','bar']);
        $this->assertTrue(is_array($f->toArray()));
        $this->assertTrue(array_key_exists('name',$f->toArray()));
    }

	public function testTb2Tuple()
    {
        $tuple = new \Badtomcat\Data\Mysql\Table2Tuple($this->con);
        $tuple->setTbName("game");
        $tuple->initTuple();
        $this->assertEquals($tuple->tuple->get('game_id')->getName(),"game_id");
        $this->assertEquals($tuple->tuple->get('introduce')->getDomain(),"800");
    }
}


