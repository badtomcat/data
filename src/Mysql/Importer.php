<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/16
 * Time: 8:50
 */

namespace Badtomcat\Data\Mysql;


use Badtomcat\Data\Tuple;
use Badtomcat\Filesystem\Condition;
use Badtomcat\Filesystem\Filter;

class Importer
{
    /**
     * @param $file
     * @return Field
     * @throws \Exception
     */
    public static function importField($file)
    {
        if (!file_exists($file))
            return null;
        $data = [];
        $rows = file($file);
        foreach ($rows as $row) {
            $row = trim($row);
            $kv = explode("=", $row, 2);
            if (count($kv) != 2)
                continue;
            //name,alias,dataType,domain,default,comment,isUnsiged,allowNull,isPk,isAutoIncrement
            switch ($kv[0]) {
                case "name":
                case "alias":
                case "dataType":
                case "default":
                case "comment":
                case "domain":
                case "domainDescription":
                    $data[$kv[0]] = $kv[1];
                    break;
                case "isUnsiged":
                case "allowNull":
                case "isPk":
                case "isAutoIncrement":
                    $data[$kv[0]] = (($kv[1] == "1" || $kv[1] == "true") ? true : false);
                    break;
            }
        }
        if (!isset($data["dataType"])) {
            throw new \Exception("required dataType field");
        }
        if (!isset($data["name"])) {
            throw new \Exception("required name field");
        }
        switch ($data["dataType"]) {
            case "enum":
            case "set":
                if (isset($data['domain'])) {
                    $data['domain'] = explode(",", $data['domain']);
                }
                if (isset($data['domainDescription'])) {
                    $data['domainDescription'] = array_combine($data['domain'],explode(",", $data['domainDescription'])) ;
                }
        }
        return new Field($data);
    }

    /**
     * @param $dir
     * @param Condition|null $condition
     * @param bool $recursive
     * @return Tuple
     * @throws \Exception
     */
    public static function importTuple($dir, Condition $condition = null, $recursive = false)
    {
        $files = Filter::getFiles($dir,$condition,$recursive);
        $tuple = new Tuple();
        foreach ($files as $file)
        {
            $tuple->append(self::importField($file));
        }
        return $tuple;
    }
}