<?php

/**
 * @Author: awei.tian
 * @Date: 2016年8月3日
 * @Desc: Tuple 元组 关系表中的一行称为一个元组
 * 依赖:
 */

namespace Badtomcat\Data;

class Tuple implements \IteratorAggregate
{
    /**
     * @var Component[] $children
     */
    protected $children = array();

    public function __construct(array $data = array())
    {
        foreach ($data as $t) {
            if ($t instanceof Component) {
                $this->children [] = $t;
            }
        }
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator ($this->children);
    }

    /**
     * 按现有ORDER排序
     * @return Tuple
     */
    public function order()
    {
        $copy = $this->children;
        usort($copy, function (Component $a, Component $b) {
            $ao = $a->getOrder();
            $bo = $b->getOrder();
            if ($ao == $bo)
                return 0;
            return ($ao < $bo) ? -1 : 1;
        });
        $this->children = [];
        foreach ($copy as $component) {
            $this->children[$component->getName()] = $component;
        }
        return $this;
    }

    /**
     * 返回当前FOREACH顺序
     * @return array
     */
    public function getOrderIndex()
    {
        return array_keys($this->children);
    }

    /**
     * 让COMPONENT不是紧密的连在一起
     * @param $step
     * @return Tuple
     */
    public function addStepToOrder($step = 10)
    {
        $i = 0;
        foreach ($this->children as $child) {
            $child->setOrder($child->getOrder() + $i * $step);
            $i++;
        }
        return $this;
    }

    /**
     *
     * @param Tuple $tuple
     * @return $this
     */
    public function appendTuple(Tuple $tuple)
    {
        foreach ($tuple as $t) {
            $this->append($t);
        }
        return $this;
    }

    /**
     * THIS中不存在,添加
     * 同时存在,REWRITE
     * 存在THIS,不存在TUPLE中,保留
     * @param Tuple $tuple
     * @return $this
     */
    public function rewrite(Tuple $tuple)
    {
        foreach ($tuple as $component) {
            $c = $this->get($component->getName());
            if ($c != null) {
                $c->rewrite($component->toArray());
            } else {
                $this->append($component);
            }
        }
        return $this;
    }

    /**
     * @param $name
     * @return Component
     */
    public function get($name)
    {
        if (isset($this->children[$name]))
            return $this->children[$name];
        return null;
    }


    /**
     * @return int
     */
    public function length()
    {
        return count($this->children);
    }

    /**
     *
     * @param Component $component
     * @return $this
     */
    public function append(Component $component)
    {
        $this->children [$component->getName()] = $component;
        return $this;
    }

    /**
     * 内部进行了ORDER和addStepToOrder
     * @param $name
     * @param Component $component
     * @return $this|bool
     */
    public function insertBefore($name, Component $component)
    {
        if (!array_key_exists($name, $this->children))
            return false;
        $this->order();
        $this->addStepToOrder();
        $component->setOrder($this->get($name)->getOrder() - 5);
        $this->append($component);
        $this->order();
        return $this;
    }

    /**
     * 内部进行了ORDER和addStepToOrder
     * @param $name
     * @param Component $component
     * @return $this|bool
     */
    public function insertAfter($name, Component $component)
    {
        if (!array_key_exists($name, $this->children))
            return false;
        $this->order();
        $this->addStepToOrder();
        $component->setOrder($this->get($name)->getOrder() + 5);
        $this->append($component);
        $this->order();
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function remove($name)
    {
        if (isset ($this->children [$name])) {
            unset ($this->children [$name]);
        }
        return $this;
    }
//
//    /**
//     * Whether a offset exists
//     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
//     * @param mixed $offset <p>
//     * An offset to check for.
//     * </p>
//     * @return boolean true on success or false on failure.
//     * </p>
//     * <p>
//     * The return value will be casted to boolean if non-boolean was returned.
//     * @since 5.0.0
//     */
//    public function offsetExists($offset)
//    {
//        return isset($this->children[$offset]);
//    }
//
//    /**
//     * Offset to retrieve
//     * @link http://php.net/manual/en/arrayaccess.offsetget.php
//     * @param mixed $offset <p>
//     * The offset to retrieve.
//     * </p>
//     * @return mixed Can return all value types.
//     * @since 5.0.0
//     */
//    public function offsetGet($offset)
//    {
//        return $this->children[$offset];
//    }
//
//    /**
//     * Offset to set
//     * @link http://php.net/manual/en/arrayaccess.offsetset.php
//     * @param mixed $offset <p>
//     * The offset to assign the value to.
//     * </p>
//     * @param mixed $value <p>
//     * The value to set.
//     * </p>
//     * @return void
//     * @since 5.0.0
//     */
//    public function offsetSet($offset, $value)
//    {
//        $this->children[$offset] = $value;
//    }
//
//    /**
//     * Offset to unset
//     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
//     * @param mixed $offset <p>
//     * The offset to unset.
//     * </p>
//     * @return void
//     * @since 5.0.0
//     */
//    public function offsetUnset($offset)
//    {
//        unset($this->children[$offset]);
//    }
}