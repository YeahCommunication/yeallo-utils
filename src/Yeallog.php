<?php

namespace Yeallo;

class Yeallog extends Yeallo {
    public static $TYPE_LOG_CUSTOM = 1;
    public static $TYPE_API        = 2;
    public static $TYPE_LOG_FILE   = 3;

    public static $STATUS_SUCCESS  = 1;
    public static $STATUS_WARNING  = 2;
    public static $STATUS_DANGER   = 3;

    public static function createLog($status, $title, $response, $project, $projectTarget = null, $type = 2,
                                     $method = null, $url = null, $body = null, $responseCode = null, $header = null) {
        $source = null;
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        if(isset($backtrace[0]) && is_array($backtrace[0])) {
            $source = $backtrace[0];
            $removeParameters = ['args', 'function', 'class', 'type'];
            foreach ($removeParameters as $removeParameter) {
                if(isset($source[$removeParameter])) unset($source[$removeParameter]);
            }
            $source = json_encode($source);
        }

        return self::call('/yeallog/save?token=' . self::getToken(), [
            'project' => $project,
            'projectTarget' => $projectTarget,
            'type' => $type,
            'status' => $status,
            'title' => $title,
            'url' => $url,
            'body' => $body,
            'responseCode' => $responseCode,
            'response' => $response,
            'method' => $method,
            'header' => $header,
            'source' => $source,
            'isTest' => (self::getServer('ENABLE_YEALLOG_TEST') == 'true' || self::getServer('ENABLE_YEALLOG_TEST') === true)
        ]);
    }
}
