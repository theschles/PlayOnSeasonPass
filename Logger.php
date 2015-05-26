<?php

/**
 * Created by PhpStorm.
 * User: phil
 * Date: 5/26/15
 * Time: 1:31 PM
 */
class Logger
{
    /**
     * @var string
     */
    private static $filename = "playon_season_pass.log";

    /**
     * @var bool
     */
    public static $debug = true;

    /**
     * @var bool
     */
    public static $info = true;

    /**
     * @var bool
     */
    public static $warn = true;

    /**
     * @var bool
     */
    public static $error = true;

    /**
     *
     */
    public static function initialSetup() {
        self::$fullPathFilename = __DIR__.DIRECTORY_SEPARATOR.self::$filename;
    }


    /**
     * @param $message
     */
    public function debug($message) {
        if (self::$debug) self::log("DEBUG " . $message);
    }

    public function info($message) {
        if (self::$info) self::log("INFO " . $message);
    }

    public function error($message) {
        if (self::$error) self::log("ERROR " . $message);
    }

    public function warn($message) {
        if (self::$warn) self::log("WARN " . $message);
    }

    private function log($message) {
        $callers = debug_backtrace();
        $function = $callers[2]['function'];
        $class = $callers[2]['class'];
        file_put_contents(self::$fullPathFilename,"$class::$function -> $message\n",FILE_APPEND|LOCK_EX);
    }

}