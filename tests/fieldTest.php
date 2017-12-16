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

    /**
     * @throws Exception
     */
    public function testImport()
    {
        $field = \Badtomcat\Data\Mysql\Importer::importField(__DIR__.'/meta/fielda.txt');
        $this->assertFalse($field->isPk());
        $this->assertEquals($field->getAlias(),"foo text");
        $this->assertTrue($field->domainChk('c'));
        $this->assertTrue($field->domainChk('cb'));
        $this->assertTrue($field->domainChk(''));

        $this->assertFalse($field->domainChk('foo'));

        $field = \Badtomcat\Data\Mysql\Importer::importField(__DIR__.'/meta/fieldb.txt');
        $this->assertTrue($field->domainChk('bbb'));
        $this->assertFalse($field->domainChk('foo'));
        $this->assertTrue(is_array($field->getDomain()));
        $this->assertTrue(array_key_exists('aaa',$field->getDomainDescription()));
        $this->assertEquals("d text",$field->getDomainDescription('dd'));


        $tuple = \Badtomcat\Data\Mysql\Importer::importTuple(__DIR__.'/meta');

        $this->assertEquals(2,$tuple->length());
        $field = $tuple->get('foo');
        $this->assertEquals("foo",$field->getName());

        $field = $tuple->get('bar');

        $this->assertTrue($field->domainChk('dd'));

        $this->assertFalse($field->domainChk('ee'));
    }
}


