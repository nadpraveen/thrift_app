<?php

function dirreader($directory, array $excludefiles = ['.', '..']) {

    $files = [];

    if (!is_dir($directory)) {
        return null;
    }

    if (!($filedir = opendir($directory))) {
        return null;
    }

    while (($file = readdir($filedir)) !== false) {

        if (in_array($file, $excludefiles)) {
            continue;
        }

        $files[] = $directory . '/' . $file;
    }

    closedir($filedir);
    return $files;
}