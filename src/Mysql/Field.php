<?php

/**
 * @Author: awei.tian
 * @Date: 2016年9月5日
 * @Desc: 
 * 	MySQL支持大量的列类型，它可以被分为3类：
 * 		数字类型、
 * 		日期和时间类型以及
 * 		字符串(字符)类型
 * 
 * 
 * 		MYSQL字段的域有
 * 			tinyint,	smallint,	int,		bigint
 * 			float,		double,		decimal,	mediumint
 * 			text,		tinyblob,	tinytext,	blob
 * 			mediumblob,	mediumtext,	longblob,	longtext
 *			datetime,	timestamp,	date,		time
 *			year,		enum,		set,		varchar
 *			char,		binary,		varbinary
 * 依赖:
 */
namespace Badtomcat\Data\Mysql;

use Badtomcat\Data\Component;
use Badtomcat\Validator\DateValidator;
use Badtomcat\Validator\NumberValidator;

class Field extends Component {
    /**
     * @return $this
     */
    public function setDataType_tinyint()
    {
        parent::setDataType("tinyint");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_smallint()
    {
        parent::setDataType("smallint");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_int()
    {
        parent::setDataType("int");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_decimal()
    {
        parent::setDataType("decimal");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_mediumint()
    {
        parent::setDataType("mediumint");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_float()
    {
        parent::setDataType("float");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_double()
    {
        parent::setDataType("double");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_text()
    {
        parent::setDataType("text");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_tinyblob()
    {
        parent::setDataType("tinyblob");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_tinytext()
    {
        parent::setDataType("tinytext");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_blob()
    {
        parent::setDataType("blob");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_mediumblob()
    {
        parent::setDataType("mediumblob");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_mediumtext()
    {
        parent::setDataType("mediumtext");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_longblob()
    {
        parent::setDataType("longblob");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_varchar()
    {
        parent::setDataType("varchar");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_char()
    {
        parent::setDataType("char");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_binary()
    {
        parent::setDataType("binary");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_varbinary()
    {
        parent::setDataType("varbinary");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_datetime()
    {
        parent::setDataType("datetime");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_timestamp()
    {
        parent::setDataType("timestamp");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_time()
    {
        parent::setDataType("time");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_date()
    {
        parent::setDataType("date");
        return $this;
    }


    /**
     * @return $this
     */
    public function setDataType_year()
    {
        parent::setDataType("year");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_enum()
    {
        parent::setDataType("enum");
        return $this;
    }

    /**
     * @return $this
     */
    public function setDataType_set()
    {
        parent::setDataType("set");
        return $this;
    }

    public function domainChk($value) {
		switch ($this->dataType) {
			case "tinyint" :
			case "smallint" :
			case "int" :
			case "decimal" :
			case "mediumint" :
			    $validator = new NumberValidator();
				if ($this->isUnsiged) {
				    $validator->unsignedOnly = true;
				}
				return $validator->validate($value);
			case "float" :
			case "double" :
                $validator = new NumberValidator();
                return $validator->validate($value);
			case "text" :
			case "tinyblob" :
			case "tinytext" :
			case "blob" :
			case "mediumblob" :
			case "mediumtext" :
			case "longblob" :
			case "longtext" :
			case "varchar" :
			case "char" :
			case "binary" :
			case "varbinary" :
				if ($this->allowNull)
					return true;
				else
					return strlen ( $value ) > 0;
			case "datetime" :
			case "timestamp" :
			    $validator = new DateValidator();
			    $validator->mode = DateValidator::MODE_DATETIME;
				return $validator->validate ( $value );
			case "time" :
                $validator = new DateValidator();
                $validator->mode = DateValidator::MODE_TIME;
                return $validator->validate ( $value );
			case "date" :
                $validator = new DateValidator();
                $validator->mode = DateValidator::MODE_DATE;
                return $validator->validate ( $value );
			case "year" :
                $validator = new DateValidator();
                $validator->mode = DateValidator::MODE_YEAR;
                return $validator->validate ( $value );
			case "enum" :
				if (! is_array ( $this->domain ))
					return false;
				return in_array ( $value, $this->domain );
			case "set" :
				if (! is_array ( $this->domain ))
					return false;
				if (! is_array ( $value ))
					return in_array ( $value, $this->domain );
				else {
					$ret = true;
					foreach ( $value as $item ) {
						if (! in_array ( $item, $this->domain )) {
							$ret = false;
							break;
						}
					}
					return $ret;
				}
		}
		return false;
	}
}