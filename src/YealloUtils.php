<?php

namespace Yeallo;

class YealloUtils extends Yeallo {

    public static function generateBarCode($text) {
        return self::$baseUrl . '/generate-bar-code?token='. self::getToken() .'&text=' . $text;
    }

    public static function sendSlack($channel, $text, $from = 'Yeallo', $icon = 'https://yeallo.fr/theme/img/yeallo_mascotte_slack.png') {
        return self::call('/slack/send?token=' . self::getToken(), [
            'to' => $channel,
            'from' => $from,
            'text' => $text,
            'withIcon' => $icon,
        ]);
    }

    public static function objectToArray($obj, &$memo = []) {
        if (in_array($obj, $memo, true)) {
            return $obj;
        }

        $memo[] = $obj;

        $obj = (array) $obj;

        foreach ($obj as $key => $val) {
            if (is_object($val) || $val instanceof \StdClass || is_array($val)) {
                $obj[$key] = self::objectToArray($val, $memo);
            } else {
                $obj[$key] = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
            }
        }

        return $obj;
    }
}
