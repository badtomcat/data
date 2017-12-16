<?php

/**
 * @Author: awei.tian
 * @Date: 2016年8月3日
 * @Desc: Tuple 元组 关系表中的一行称为一个元组
 * 依赖:
 */
namespace Badtomcat\Data;

class Tuple implements \IteratorAggregate {
	private $children = array ();
	public function __construct(array $data = array()) {
		foreach ( $data as $t ) {
			if ($t instanceof Component) {
				$this->children [] = $t;
			}
		}
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see IteratorAggregate::getIterator()
	 */
	public function getIterator() {
	    usort($this->children,function(Component $a,Component $b){
	        if ($a->getOrder() == $b->getOrder())
	            return 0;
	        return ($a->getOrder() < $b->getOrder()) ? -1: 1;
        });
		return new \ArrayIterator ( $this->children );
	}


	/**
	 *
	 * @param Tuple $tuple
	 * @return $this
	 */
	public function appendTuple(Tuple $tuple) {
		foreach ( $tuple as $t ) {
			$this->append ( $t );
		}
		return $this;
	}


    /**
     * @param $name
     * @return Component
     */
	public function get($name) {
	    return $this->children[$name];
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
	public function append(Component $component) {
		$this->children [$component->getName()] = $component;
		return $this;
	}

    /**
     * @param $name
     * @return $this
     */
	public function remove($name) {
		if (isset ( $this->children [$name] )) {
			unset ( $this->children [$name] );
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