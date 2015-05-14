<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 5/14/15
 * Time: 12:18 PM
 */

class PlayOnServerInteraction {

    /**
     * @var string
     */
    protected static $url = "";

    /**
     * @param string $url
     */
    public static function setURL($url) {
        self::$url = $url;
    }

    /**
     * @return SimpleXMLElement
     */
    private static function getCBS() {
        $queryCBS = "/data/data.xml?id=cbs";
        $cbsResult = file_get_contents(self::$url.$queryCBS);
        $cbsResultXML = simplexml_load_string($cbsResult);
        return $cbsResultXML;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return SimpleXMLElement
     */
    private static function getAllCurrentShows(SimpleXMLElement $xml) {
        $name = 'All Current Shows';
        $resultXML = Utility::getXMLFromXPath($xml,$name);
        return $resultXML;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return SimpleXMLElement
     */
    private static function getBigBangTheory(SimpleXMLElement $xml) {
        $name = 'The Big Bang Theory';
        $resultXML = Utility::getXMLFromXPath($xml,$name);
        return $resultXML;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return SimpleXMLElement
     */
    private static function getFullEpisodes(SimpleXMLElement $xml) {
        $name = 'Full Episodes';
        $resultXML = Utility::getXMLFromXPath($xml,$name);
        return $resultXML;
    }


    /**
     * @param SimpleXMLElement $xml
     * @return SimpleXMLElement
     */
    private static function getSeason8(SimpleXMLElement $xml) {
        $name = 'Season 8';
        $resultXML = Utility::getXMLFromXPath($xml,$name);
        return $resultXML;
    }

    public static function recordEpisode(array $episodeData) {
        
    }

    /**
     * @return SimpleXMLElement
     */
    public static function getListOfPublishedVideo()
    {
        $cbsResultXML = self::getCBS();
        $allCurrentShowsXML = self::getAllCurrentShows($cbsResultXML);
        $bigBangTheoryXML = self::getBigBangTheory($allCurrentShowsXML);
        $fullEpisodesXML = self::getFullEpisodes($bigBangTheoryXML);
        $season8XML = self::getSeason8($fullEpisodesXML);
        return $season8XML;
    }

}