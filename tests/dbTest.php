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

	public function testTb2Tuple()
    {
        $tuple = new \Badtomcat\Data\Mysql\Table2Tuple($this->con);
        $tuple->setTbName("game");
        $tuple->initTuple();
        $this->assertEquals($tuple->tuple[0]->name,"game_id");
        $this->assertEquals($tuple->tuple[2]->domain,"800");
    }
}


