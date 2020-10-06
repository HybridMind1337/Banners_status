<?php
require_once __DIR__ . '/vendor/autoload.php';
$ServerIP = $_GET['ip']; // Взимаме IP-to
$game = $_GET['game']; // Взимаме играта

// Функция за съкращаване на текста
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

// Взимаме информация от GameQ
$GameQ = new \GameQ\GameQ();
$GameQ->addServer(['type' => '' . $game . '', 'host' => '' . $ServerIP . '', ]);
$GameQ->setOption('timeout', 5);
$GameQ->addFilter('normalize');

$results = $GameQ->process();

$gameIco = imagecreatefrompng('images/games/' . $game . '.png'); // Генерираме иконката на избраната игра
$getBack = imagecreatefrompng("images/small.png"); // Генерираме задния фон

foreach ($results as $get) {

    $servName = $get["gq_hostname"]; // Взимаме името на сървъра

    if (!$servName) { 
        $status = imagecreatefrompng('images/offline.png'); // Генерираме иконата, че offline
        $color = ImageColorAllocate($getBack, 255, 255, 255); // Бял цвят

        imagettftext($getBack, 9, 0, 60, 20, $color, __DIR__ . "/arial.ttf", "$ServerIP в момента не работи!"); // Показваме, че сървъра не работи

        imagecopy($getBack, $status, 4, 10, 0, 0, 9, 14); // Поставяме иконката за offline
    } else {
        $players = $get["gq_numplayers"]; // Взимаме играчите
        $maxplayers = $get["gq_maxplayers"]; // Взимаме общите слотове
        $servName = $get["gq_hostname"]; // Взимаме името на сървъра
        $map = $get["gq_mapname"]; // Взимаме името на картата
 
        $status = imagecreatefrompng('images/online.png'); // Генерираме иконка за online

        // Цветове, които ще използваме
        $white = ImageColorAllocate($getBack, 248, 248, 255);
        $blue = ImageColorAllocate($getBack, 4, 226, 233);
        $green = ImageColorAllocate($getBack, 0, 209, 0);
        $orange = ImageColorAllocate($getBack, 244, 164, 0);

        imagettftext($getBack, 7.5, 0, 17, 12, $white, __DIR__ . "/arial.ttf", "" . truncate_string($servName, 49, '..') . ""); // Показваме името на сървъра
        imagettftext($getBack, 7.5, 0, 17, 25, $blue, __DIR__ . "/arial.ttf", "IP: $ServerIP"); // Показваме IP  адреса
        imagettftext($getBack, 7.5, 0, 155, 25, $green, __DIR__ . "/arial.ttf", "Играчи: " . $players . "/" . $maxplayers . ""); // Показваме общите играчи
        imagettftext($getBack, 7.5, 0, 240, 25, $orange, __DIR__ . "/arial.ttf", "Карта: " . truncate_string($map, 10, '..') . ""); // Показваме името на картата
        imagecopy($getBack, $status, 4, 10, 0, 0, 9, 14); // Добавяме иконката за online
        imagecopy($getBack, $gameIco, 333, 7, 0, 0, 16, 16); // Добавяме иконката на играта
    }
}
header("Content-type: image/png; charset=utf-8");

imagepng($getBack);
imagedestroy($getBack);

