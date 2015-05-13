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
    protected $alreadyRecordedEpisodesFile = "PlayOnSeasonPassAlreadyRecordedEpisodes.json";
    protected $fullPathAlreadyRecordedEpisodesFile = "";

    function main() {
        $this->initialSetup();
        $cbsResultXML = $this->getCBS();
        $allCurrentShowsXML = $this->getAllCurrentShows($cbsResultXML);
        $bigBangTheoryXML = $this->getBigBangTheory($allCurrentShowsXML);
        $fullEpisodesXML = $this->getFullEpisodes($bigBangTheoryXML);
        $season8XML = $this->getSeason8($fullEpisodesXML);
        $viewableEpisodesArray = $this->findViewableEpisodes($season8XML);
        $alreadyDownloadedEpisodes = $this->getAlreadyDownloadedEpisodes();
        $listOfEpisodesToDownload = $this->getListOfEpisodesToDownload($viewableEpisodesArray,$alreadyDownloadedEpisodes);
        $recordCommandSuccess = $this->recordNewEpisodes($listOfEpisodesToDownload);
        $updatedEpisodeList = "";
        if ($recordCommandSuccess !== false) {
            $updatedEpisodeList = $this->addNewlyRecordedEpisodesToEpisodeList($alreadyDownloadedEpisodes,$listOfEpisodesToDownload);
            $saveUpdatedEpisodeListSuccess = $this->saveDownloadedEpisodes($updatedEpisodeList);
            if ($saveUpdatedEpisodeListSuccess == false) {
                throw new Exception("Failed to save: already downloaded list: ".$alreadyDownloadedEpisodes." ; episodes to record: ".$listOfEpisodesToDownload." ; updated episode list: ".$updatedEpisodeList);
            } else {
                die("All done!");
            }
        } else {
            throw new Exception("Failed to record new episodes: already downloaded list: ".$alreadyDownloadedEpisodes." ; episodes to record: ".$listOfEpisodesToDownload);
        }
    }

    function initialSetup() {
        $this->fullPathAlreadyRecordedEpisodesFile = __DIR__.DIRECTORY_SEPARATOR.$this->alreadyRecordedEpisodesFile;
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

    function getAlreadyDownloadedEpisodes() {
        if (!file_exists($this->fullPathAlreadyRecordedEpisodesFile)) {
            return null;
        } else {
            return json_decode(file_get_contents($this->fullPathAlreadyRecordedEpisodesFile));
        }
    }

    function saveDownloadedEpisodes($episodes) {
        return file_put_contents($this->fullPathAlreadyRecordedEpisodesFile,json_encode($episodes),LOCK_EX);
    }


    function getListOfEpisodesToDownload($viewableEpisodesArray,$alreadyDownloadedEpisodes) {

    }

    function recordNewEpisodes($listOfEpisodesToDownload) {

    }

    function addNewlyRecordedEpisodesToEpisodeList($alreadyDownloadedEpisodes,$listOfEpisodesToDownload) {
        
    }
}