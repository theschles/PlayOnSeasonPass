<?php
/**
 * Created by PhpStorm.
 * User: phil
 * Date: 5/13/15
 * Time: 12:58 PM
 */

class Persistence {

    protected static $alreadyRecordedEpisodesFile = "PlayOnSeasonPassAlreadyRecordedEpisodes.json";
    protected static $fullPathAlreadyRecordedEpisodesFile = "";

    public static function initialSetup() {
        self::$fullPathAlreadyRecordedEpisodesFile = __DIR__.DIRECTORY_SEPARATOR.self::$alreadyRecordedEpisodesFile;
    }

    public static function getAlreadyDownloadedEpisodes() {
        if (!file_exists(self::$fullPathAlreadyRecordedEpisodesFile)) {
            return null;
        } else {
            return json_decode(file_get_contents(self::$fullPathAlreadyRecordedEpisodesFile));
        }
    }

    public static function saveDownloadedEpisodes($episodes) {
        return file_put_contents(self::$fullPathAlreadyRecordedEpisodesFile,json_encode($episodes),LOCK_EX);
    }
}