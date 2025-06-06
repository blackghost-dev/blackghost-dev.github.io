<?php

function listupdate() {
    $f = [];
    $dir_path = str_replace("\\", "/", dirname(__FILE__));
    $path_base = $dir_path . '/plugin.video.spartanaddon';
    if (file_exists($path_base)) {
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path_base)) as $file) {
            if ($file->isFile() && $file->getExtension() === 'py') {
                $p_base = $file->getPathname();
                $p = str_replace($path_base, '/plugin.video.spartanaddon', $p_base);
                $p = str_replace("//", "/", $p);
                $p = str_replace("\\", "/", $p);
                $f[] = $p;
            }
        }
    }
    return json_encode($f, JSON_UNESCAPED_SLASHES);
}

echo listupdate();

?>


