<?php

function randStrGen() {
    $result = "";
    $chars = "0123456789";
    $charArray = str_split($chars);
    for ($i = 0; $i <= 4; $i++) {
        $randItem = array_rand($charArray);
        $result .="" . $charArray[$randItem];
    }
    return $result;
}


function escape($str){
    $str = htmlspecialchars($str, ENT_QUOTES, 'utf-8');
    return $str;
}