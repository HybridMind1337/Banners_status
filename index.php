<?php
require_once __DIR__ . '/vendor/autoload.php';
$ServerIP = $_GET['ip'];
$game = $_GET['game'];
function truncate_string($string, $max_chars, $end_chars) {
    $text_len = strlen($string);
    $temp_text = '';
    if ($text_len > $max_chars) {
        for ($i = 0;$i < $max_chars;$i++) {
            $temp_text.= $string[$i];
        }
        $temp_text.= $end_chars;
        return $temp_text;
    } else {
        return $string;
    }
}
$GameQ = new \GameQ\GameQ();
$GameQ->addServer(['type' => '' . $game . '', 'host' => '' . $ServerIP . '', ]);
$GameQ->setOption('timeout', 5); 
$GameQ->addFilter('normalize');
$results = $GameQ->process();
$gameIco = imagecreatefrompng('images/games/' . $game . '.png');
$getBack = imagecreatefrompng("images/small.png");
for ($i = 0;$i < count($results);$i++) {
    foreach ($results as $k => $v) {
        unset($results[$k]);
        $new_key = $i;
        $results[$new_key] = $v;
    }
    $servName = $results[$i]["gq_hostname"];
    if (!$servName) {
        $status = imagecreatefrompng('images/offline.png');
        $color = ImageColorAllocate($getBack, 255, 255, 255);
        imagettftext($getBack, 9, 0, 60, 20, $color, __DIR__ . "/arial.ttf", "$ServerIP в момента не работи!");
        imagecopy($getBack, $status, 4, 10, 0, 0, 9, 14);
    } else {
        $players = $results[$i]["gq_numplayers"];
        $maxplayers = $results[$i]["gq_maxplayers"];
        $servName = $results[$i]["gq_hostname"];
        $map = $results[$i]["gq_mapname"];

        $status = imagecreatefrompng('images/online.png');
        $white = ImageColorAllocate($getBack, 248, 248, 255);
        $blue = ImageColorAllocate($getBack, 4, 226, 233);
        $green = ImageColorAllocate($getBack, 0, 209, 0);
        $orange = ImageColorAllocate($getBack, 244, 164, 0);
        imagettftext($getBack, 7.5, 0, 17, 12, $white, __DIR__ . "/arial.ttf", "" . truncate_string($servName, 49, '..') . "");
        imagettftext($getBack, 7.5, 0, 17, 25, $blue, __DIR__ . "/arial.ttf", "IP: $ServerIP");
        imagettftext($getBack, 7.5, 0, 155, 25, $green, __DIR__ . "/arial.ttf", "Играчи: " . $players . "/" . $maxplayers . "");
        imagettftext($getBack, 7.5, 0, 240, 25, $orange, __DIR__ . "/arial.ttf", "Карта: " . truncate_string($map, 10, '..') . "");
        imagecopy($getBack, $status, 4, 10, 0, 0, 9, 14);
        imagecopy($getBack, $gameIco, 333, 7, 0, 0, 16, 16);
    }
}
header("Content-type: image/png; charset=utf-8");
imagepng($getBack);
imagedestroy($getBack);
exit;
