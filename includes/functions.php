<?php
/**
 * @file functions.php
 * @created 20.2.2021 г.
 *
 * @author HybridMind
 * @email support@webocean.info
 * @discord HybridMind#6095
 *
 */

function checkIP($ip): bool
{
    if (!filter_var($ip, FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV4,]) && $ip === gethostbyname($ip)) {
        return true;
    }
}

/**
 * @param $string
 * @param $max_chars
 * @param $end_chars
 * @return string
 */
function truncate_string($string, $max_chars, $end_chars): string
{
    $text_len = strlen($string);
    $temp_text = '';
    if ($text_len > $max_chars) {
        for ($i = 0; $i < $max_chars; $i++) {
            $temp_text .= $string[$i];
        }
        $temp_text .= $end_chars;
        return $temp_text;
    } else {
        return $string;
    }
}
