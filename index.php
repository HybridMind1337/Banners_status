<?php
header("Content-type: image/png; charset=utf-8");

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/includes/functions.php";

$URL = explode("/", htmlspecialchars($_SERVER['QUERY_STRING']));

if(!checkIP($URL[1])) {
    header("Location: ../index.ph");
}

$GameQ = new \GameQ\GameQ();
$GameQ->addServer([
    'type' => $URL[0],
    'host' => $URL[1],
]);
$GameQ->setOption('timeout', 5);
$GameQ->addFilter('normalize');

$results = $GameQ->process();

$result = $results[$URL[1]];

$getBack = imagecreatefrompng("images/small.png");

if (file_exists(__DIR__ . "/images/games/$URL[0].png")) {
    $gameIco = imagecreatefrompng('images/games/' . $URL[0] . '.png');
    imagecopy($getBack, $gameIco, 333, 7, 0, 0, 16, 16);
}

$white = ImageColorAllocate($getBack, 248, 248, 255);

if ($result['gq_online'] == '1') {
    $status = imagecreatefrompng('images/online.png');
} else {
    $status = imagecreatefrompng('images/offline.png');
}

$hostName = (isset($result['gq_hostname']) && $result['gq_hostname'] != "" ? $result['gq_hostname'] : 'N/A');
$maxPlayers = (isset($result['gq_maxplayers']) && $result['gq_maxplayers'] != "" ? $result['gq_maxplayers'] : '0');
$onlinePlayers = (isset($result['gq_numplayers']) && $result['gq_numplayers'] != "" ? $result['gq_numplayers'] : '0');
$map = (isset($result['gq_mapname']) && $result['gq_mapname'] != "" ? $result['gq_mapname'] : 'N/A');

imagettftext($getBack, 7.5, 0, 17, 12, $white, __DIR__ . "/arial.ttf", "" . truncate_string($hostName, 49, '..') . "");
imagettftext($getBack, 7.5, 0, 155, 25, $white, __DIR__ . "/arial.ttf", "Играчи: $onlinePlayers / $maxPlayers");
imagettftext($getBack, 7.5, 0, 240, 25, $white, __DIR__ . "/arial.ttf", "Карта: " . truncate_string($map, 8, '..') . "");
imagettftext($getBack, 7.5, 0, 17, 25, $white, __DIR__ . "/arial.ttf", "IP: $URL[1]");
imagecopy($getBack, $status, 4, 10, 0, 0, 9, 14);

imagepng($getBack);
imagedestroy($getBack);
