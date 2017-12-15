<?php


use Badtomcat\Db\Connection\MysqlPdoConn;

class fieldTest extends PHPUnit_Framework_TestCase {
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
        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("foo");
        $field->setDomain(['a','b','c']);
        $field->setDefault("b");
        $field->setAlias("电源线");
        $field->setDataType_enum();
        $this->assertTrue($field->domainChk('c'));

        $this->assertFalse($field->domainChk('f'));
    }
}


