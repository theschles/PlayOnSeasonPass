<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 3/31/15
 * Time: 4:56 PM
 */

//SeasonPass::main();

$seasonPass = new SeasonPass();
$seasonPass->main();

class SeasonPass {

    protected $url = "http://192.168.1.86:54479";

    function main() {
        $cbsResultXML = $this->getCBS();
        $allCurrentShowsXML = $this->getAllCurrentShows($cbsResultXML);
        $bigBangTheoryXML = $this->getBigBangTheory($allCurrentShowsXML);
        $fullEpisodesXML = $this->getFullEpisodes($bigBangTheoryXML);
        $season8XML = $this->getSeason8($fullEpisodesXML);
        $viewableEpisodesArray = $this->findViewableEpisodes($season8XML);
        $alreadyDownloadedEpisodes = $this->getAlreadyDownloadedEpisodes();
        $listOfEpisodesToDownload = $this->getListOfEpisodesToDownload($viewableEpisodesArray,$alreadyDownloadedEpisodes);
    }

    function getCBS() {
        $queryCBS = "/data/data.xml?id=cbs";
        $cbsResult = file_get_contents($this->url.$queryCBS);
        $cbsResultXML = simplexml_load_string($cbsResult);
        return $cbsResultXML;
    }

    function getAllCurrentShows($xml) {
        $name = 'All Current Shows';
        $resultXML = $this->getXMLFromXPath($xml,$name);
        return $resultXML;
    }

    function getBigBangTheory($xml) {
        $name = 'The Big Bang Theory';
        $resultXML = $this->getXMLFromXPath($xml,$name);
        return $resultXML;
    }

    function getFullEpisodes($xml) {
        $name = 'Full Episodes';
        $resultXML = $this->getXMLFromXPath($xml,$name);
        return $resultXML;
    }

    function getSeason8($xml) {
        $name = 'Season 8';
        $resultXML = $this->getXMLFromXPath($xml,$name);
        return $resultXML;
    }

    function findViewableEpisodes($xml) {
        $viewableEpisodes = array();
        foreach ($xml->children() as $child) {
            $type = $child->attributes()['type'];
            if ($type != "video") {
                continue;
            }
            $episodeCombinedName = $child->attributes()['name']->__toString();
            if (strpos($episodeCombinedName,"e00")) {
                continue;
            }
            $episodeNameData = explode(" - ",$episodeCombinedName);
            $episodeData['number'] = $episodeNameData[0];
            $episodeData['name'] = $episodeNameData[1];
            $episodeData['href'] = $child->attributes()['href']->__toString();
            $viewableEpisodes[] = $episodeData;
        }
        return $viewableEpisodes;
    }

    function getXMLFromXPath($xml,$name) {
        $xpath = ".//*[@name='$name']";
        $attribute = $xml->xpath($xpath);
        $href = $attribute[0]->attributes()['href'];
        $result = file_get_contents($this->url.$href);
        $resultXML = simplexml_load_string($result);
        return $resultXML;
    }


}