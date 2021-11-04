<?php

include 'direader.php';

//$files = dirreader('user_img');
//usort($files, function($x, $y) {
//    return filemtime($x) < filemtime($y);
//});
//
//foreach ($files as $item) {
//    echo basename($item) . " => Last Modified On " . @date('F d, Y, H:i:s', filemtime($item)) . "<br/>";
//}

$file = 'user_img/122562_pht.jpg';
$mod_time = filemtime($file);
echo date('d-m-Y', strtotime($mod_time));
