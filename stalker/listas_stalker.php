<?php
// Diretório atual
$dir = __DIR__;

// Array para armazenar os nomes dos arquivos txt
$files = [];

// Lista todos os arquivos no diretório
$directory = new DirectoryIterator($dir);
foreach ($directory as $fileinfo) {
    if ($fileinfo->isFile() && $fileinfo->getExtension() === 'txt' && $fileinfo->getExtension() !== 'php') {
        $files[] = $fileinfo->getFilename();
    }
}

usort($files, function($a, $b) {
    return strnatcasecmp($a, $b);
});

// Transforma o array em JSON
$json = json_encode($files);

// Imprime o JSON
header('Content-Type: application/json');
echo $json;
?>
