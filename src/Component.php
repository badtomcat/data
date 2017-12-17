<?php

/**
 * @Author: awei.tian
 * @Date: 2016年8月3日
 * @Desc: 关系数据库中的分量
 * 依赖:
 */

namespace Badtomcat\Data;

abstract class Component
{
    /**
     * 字段名
     *
     * @var string
     */
    protected $name;
    /**
     * 别名
     *
     * @var string
     */
    protected $alias;

    /**
     *
     * @var string 例如:tinyint,smallint,int,bigint
     */
    protected $dataType;
    /**
     *
     * @var $domain array 一般在数据类型为集合时使用
     */
    protected $domain;
    /**
     * @var array key-value形式
     */
    protected $domainDescription;
    protected $default;
    protected $comment;

    // 根据实际情况添加三个字段
    protected $isUnsiged = false;
    protected $allowNull = true;
    protected $isPk = false;
    protected $isAutoIncrement = false;

    protected $order = 0;

    /**
     * 可用的KEY name,alias,dataType,domain,domainDescription,default,comment,isUnsiged,allowNull,isPk,isAutoIncrement,order
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->rewrite($data);
    }

    /**
     * @param array $data
     *
     * @return Component
     */
    public function rewrite(array $data = [])
    {
        foreach ($data as $key => $val) {
            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }
        return $this;
    }

    public function extend(array $data = [])
    {
        foreach ($data as $key => $val) {
            if (property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /***
     * @param string $alias
     * @return Component
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }


    /**
     * @param string $dataType
     * @return $this
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param $domain
     * @return $this
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDomainDescription($description)
    {
        $this->domainDescription = $description;
        return $this;
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getDomainDescription($key = null)
    {
        if (!is_null($key) && is_array($this->domainDescription) && array_key_exists($key, $this->domainDescription)) {
            return $this->domainDescription[$key];
        }
        return $this->domainDescription;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @param bool $unsigned
     * @return $this
     */
    public function setUnsigned($unsigned = true)
    {
        $this->isUnsiged = $unsigned;
        return $this;
    }

    public function isUnsigned()
    {
        return $this->isUnsiged;
    }

    /**
     * @param bool $autoincrement
     * @return $this
     */
    public function setAutoIncrement($autoincrement = true)
    {
        $this->isAutoIncrement = $autoincrement;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoIncrement()
    {
        return $this->isAutoIncrement;
    }


    /**
     * @param bool $allowNull
     * @return $this
     */
    public function setAllowNull($allowNull = true)
    {
        $this->allowNull = $allowNull;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowNull()
    {
        return $this->allowNull;
    }


    /**
     * @param bool $pk
     * @return $this
     */
    public function setPk($pk = true)
    {
        $this->isPk = $pk;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPk()
    {
        return $this->isPk;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $ret = [];
        foreach (explode(',', 'name,alias,dataType,domain,domainDescription,default,comment,isUnsiged,allowNull,isPk,isAutoIncrement,order') as $attr) {
            $ret[$attr] = $this->{$attr};
        }
        return $ret;
    }

    /**
     * @return null
     */
    public function getOrder()
    {
        return $this->order;
    }


    /**
     * @param $order
     * @return $this
     */
    public function setOrder($order)
    {
        if ($this->order !== $order) {
            $this->order = $order;
        }
        return $this;
    }

    /**
     *
     * @param string $value
     * @return bool
     */
    abstract public function domainChk($value);

    public static function intDomainChk($value)
    {
        return is_int($value);
    }
}