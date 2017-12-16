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
        $cmp = [];
        /**
         * @var \Badtomcat\Data\Component $component
         */
        foreach ($tuple as $component)
        {
            $cmp [] = ($component->getName());
        }
        $this->assertArraySubset($ret,$cmp);
    }
}