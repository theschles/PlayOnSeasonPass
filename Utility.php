<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 5/13/15
 * Time: 12:53 PM
 */

class Utility {
    static protected $url = "";
    static public function getXMLFromXPath($xml,$name) {
        $xpath = ".//*[@name='$name']";
        $attribute = $xml->xpath($xpath);
        $href = $attribute[0]->attributes()['href'];
        $result = file_get_contents(self::$url.$href);
        $resultXML = simplexml_load_string($result);
        return $resultXML;
    }

    static public function setURL($url) {
        self::$url = $url;
    }
}