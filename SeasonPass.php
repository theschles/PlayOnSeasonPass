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
        $this->initialSetup();
        $viewableEpisodesArray = $this->getListOfViewableEpisodes();
        $alreadyDownloadedEpisodes = Persistence::getAlreadyDownloadedEpisodes();
        $listOfEpisodesToDownload = $this->filterOutAlreadyDownloadedEpisodesFromAvailableEpisodes($viewableEpisodesArray,$alreadyDownloadedEpisodes);
        $recordCommandSuccess = $this->recordNewEpisodes($listOfEpisodesToDownload);
        die("done for now");
//        $updatedEpisodeList = "";
//        $this->processResultOfSendingRecordCommands($recordCommandSuccess, $alreadyDownloadedEpisodes, $listOfEpisodesToDownload);
    }

    public function initialSetup() {
        Utility::setURL($this->url);
        PlayOnServerInteraction::setURL($this->url);
    }

    function findViewableEpisodes(SimpleXMLElement $xml)
    {
        $viewableEpisodes = array();
        foreach ($xml->children() as $child) {
            /** @var SimpleXMLElement $child */
            $type = $child->attributes()['type'];
            if ($type != "video") {
                continue;
            }
            $episodeCombinedName = $child->attributes()['name']->__toString();
            if (strpos($episodeCombinedName, "e00")) {
                continue;
            }
            $episodeNameData = explode(" - ", $episodeCombinedName);
            $episodeData['number'] = $episodeNameData[0];
            $episodeData['name'] = $episodeNameData[1];
            $episodeData['href'] = $this->getAddToQueueHREF($child);
            $viewableEpisodes[] = $episodeData;
        }
        return $viewableEpisodes;
    }

    function addNewlyRecordedEpisodesToEpisodeList($alreadyDownloadedEpisodes,$listOfEpisodesToDownload) {
        return $alreadyDownloadedEpisodes;
    }


    function filterOutAlreadyDownloadedEpisodesFromAvailableEpisodes($viewableEpisodesArray,$alreadyDownloadedEpisodes) {
        return $viewableEpisodesArray;
    }

    function recordNewEpisodes($listOfEpisodesToDownload) {
        return true;
    }



    /**
     * @param $recordCommandSuccess
     * @param $alreadyDownloadedEpisodes
     * @param $listOfEpisodesToDownload
     * @throws Exception
     */
    function processResultOfSendingRecordCommands($recordCommandSuccess, $alreadyDownloadedEpisodes, $listOfEpisodesToDownload)
    {
        if ($recordCommandSuccess !== false) {
            $updatedEpisodeList = $this->addNewlyRecordedEpisodesToEpisodeList($alreadyDownloadedEpisodes, $listOfEpisodesToDownload);
            $saveUpdatedEpisodeListSuccess = Persistence::saveDownloadedEpisodes($updatedEpisodeList);
            if ($saveUpdatedEpisodeListSuccess == false) {
                throw new Exception("Failed to save: already downloaded list: " . $alreadyDownloadedEpisodes . " ; episodes to record: " . $listOfEpisodesToDownload . " ; updated episode list: " . $updatedEpisodeList);
            } else {
                die("All done!");
            }
        } else {
            throw new Exception("Failed to record new episodes: already downloaded list: " . $alreadyDownloadedEpisodes . " ; episodes to record: " . $listOfEpisodesToDownload);
        }
    }

    /**
     * @return array
     */
    function getListOfViewableEpisodes()
    {
        $season8XML = PlayOnServerInteraction::getListOfPublishedVideo();
        $viewableEpisodesArray = $this->findViewableEpisodes($season8XML);
        return $viewableEpisodesArray;
    }

    /**
     * @param $child
     * @return mixed
     */
    public function getAddToQueueHREF($child)
    {
        return $child->attributes()['href']->__toString();
    }
}