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
     * @var bool
     */
    private static $debug = true;

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
        Logger::debug("Entering");
        $queryCBS = "/data/data.xml?id=cbs";
        $cbsResult = file_get_contents(self::$url.$queryCBS);
        $cbsResultXML = simplexml_load_string($cbsResult);
        Logger::debug("Exiting");
        return $cbsResultXML;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return SimpleXMLElement
     */
    private static function getAllCurrentShows(SimpleXMLElement $xml) {
        Logger::debug("Entering");
        $name = 'All Current Shows';
        $resultXML = Utility::getXMLFromXPath($xml,$name);
        Logger::debug("Exiting");
        return $resultXML;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return SimpleXMLElement
     */
    private static function getBigBangTheory(SimpleXMLElement $xml) {
        Logger::debug("Entering");
        $name = 'The Big Bang Theory';
        $resultXML = Utility::getXMLFromXPath($xml,$name);
        Logger::debug("Exiting");
        return $resultXML;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return SimpleXMLElement
     */
    private static function getFullEpisodes(SimpleXMLElement $xml) {
        Logger::debug("Entering");
        $name = 'Full Episodes';
        $resultXML = Utility::getXMLFromXPath($xml,$name);
        Logger::debug("Exiting");
        return $resultXML;
    }


    /**
     * @param SimpleXMLElement $xml
     * @return SimpleXMLElement
     */
    private static function getSeason8(SimpleXMLElement $xml) {
        Logger::debug("Entering");
        $name = 'Season 8';
        $resultXML = Utility::getXMLFromXPath($xml,$name);
        Logger::debug("Exiting");
        return $resultXML;
    }

    public static function recordEpisode(array $episodeData) {
        Logger::debug("Entering");
        Logger::debug("Exiting");
    }

    /**
     * @return SimpleXMLElement
     */
    public static function getListOfPublishedVideo()
    {
        Logger::debug("Entering");
        $cbsResultXML = self::getCBS();
        $allCurrentShowsXML = self::getAllCurrentShows($cbsResultXML);
        $bigBangTheoryXML = self::getBigBangTheory($allCurrentShowsXML);
        $fullEpisodesXML = self::getFullEpisodes($bigBangTheoryXML);
        $season8XML = self::getSeason8($fullEpisodesXML);
        Logger::debug("Exiting");
        return $season8XML;
    }

}