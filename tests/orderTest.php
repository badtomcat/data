<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 17:03
 */

class orderTest extends PHPUnit_Framework_TestCase {

    public function testOrder()
    {
        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("foo");
        $field->setDomain(['a','b','c']);
        $field->setDefault("b");
        $field->setAlias("电源线");
        $field->setDataType_enum();
        $field->setOrder(2);

        $tuple = new \Badtomcat\Data\Tuple();
        $tuple->append($field);

        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("bar");
        $field->setDomain(['a','b','c']);
        $field->setDefault("b");
        $field->setAlias("电源线");
        $field->setDataType_enum();
        $field->setOrder(1);
        $tuple->append($field);

        $ret = ['bar','foo'];
        $cmp = $tuple->order()->getOrderIndex();
        $this->assertArraySubset($ret,$cmp);



    }

    public function testRewrite()
    {
        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("foo");
        $field->setDomain(['a','b','c']);
        $field->setDefault("b");
        $field->setAlias("电源线");
        $field->setDataType_enum();
        $field->setOrder(2);

        $tuple = new \Badtomcat\Data\Tuple();
        $tuple->append($field);

        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("bar");
        $field->setDomain(['a','b','c']);
        $field->setDefault("b");
        $field->setAlias("电源线");
        $field->setDataType_enum();
        $field->setOrder(1);
        $tuple->append($field);

        $component = $tuple->get("bar");
        $this->assertEquals("b",$component->getDefault());

        $new_tuple = new \Badtomcat\Data\Tuple();
        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("bar");
        $field->setDomain(['a','b','c','d']);
        $field->setDefault("d");
        $new_tuple->append($field);

        $tuple->rewrite($new_tuple);
        $tuple->order();
        $component = $tuple->get("bar");

        $this->assertArraySubset(['a','b','c','d'],$component->getDomain());
        $this->assertEquals("d",$component->getDefault());
    }



    public function testInsert()
    {
        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("foo");
        $field->setDomain(['a','b','c']);
        $field->setDefault("b");
        $field->setAlias("电源线");
        $field->setDataType_enum();
        $field->setOrder(2);

        $tuple = new \Badtomcat\Data\Tuple();
        $tuple->append($field);

        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("bar");
        $field->setDomain(['a','b','c']);
        $field->setDefault("b");
        $field->setAlias("电源线");
        $field->setDataType_enum();
        $field->setOrder(1);
        $tuple->append($field);

        $component = $tuple->get("bar");
        $this->assertEquals("b",$component->getDefault());

        $new_tuple = new \Badtomcat\Data\Tuple();
        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("bar");
        $field->setDataType_enum();
        $field->setDomain(['a','b','c','d']);
        $field->setDefault("d");
        $new_tuple->append($field);

        $field = new \Badtomcat\Data\Mysql\Field();
        $field->setName("uuu");
        $field->setDataType_varchar();
        $field->setDomain(5);
        $field->setDefault("uuu");
        $new_tuple->append($field);


        $tuple->rewrite($new_tuple);

        $this->assertEquals($tuple->get("uuu")->getDefault(),'uuu');

        $component = new \Badtomcat\Data\Mysql\Field();
        $component->setName("stand-index-0");
        $component->setDataType_varchar();

        $tuple->insertBefore("bar",$component);

        $component = new \Badtomcat\Data\Mysql\Field();
        $component->setName("stand-index-2");
        $component->setDataType_varchar();
        $tuple->insertAfter("bar",$component);

        $ret = ['uuu','stand-index-0','bar','stand-index-2','foo'];
        $cmp = $tuple->getOrderIndex();
        $this->assertArraySubset($ret,$cmp);
    }
}