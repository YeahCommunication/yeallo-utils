<?php

namespace Yeallo;

abstract class Yeallo {

    protected static $baseUrl = 'https://yeallo.fr';

    protected static function call($url, $body) {
        if(self::getServer('ENABLE_YEALLO') === true || self::getServer('ENABLE_YEALLO') == 1 || self::getServer('ENABLE_YEALLO') == 'true') {
            $url = self::$baseUrl . $url;

            $bodyClean = [];
            foreach ($body as $key => $val) {
                if(is_array($val) || is_object($val)) {
                    $bodyClean[$key] = json_encode(YealloUtils::objectToArray($val));
                } else {
                    $bodyClean[$key] = $val;
                }
            }

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n".
                                 "Cache-Control: no-cache\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($bodyClean)
                ],
                "ssl" => ["verify_peer" => false, "verify_peer_name" => false]
            ];

            $context  = stream_context_create($options);

            try {
                return file_get_contents($url, false, $context);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        return false;
    }

    protected static function getServer($name) {
        return (isset($_SERVER[$name])) ? $_SERVER[$name] : null;
    }

    protected static function getToken() {
        return self::getServer('YEALLOG_TOKEN');
    }
}
