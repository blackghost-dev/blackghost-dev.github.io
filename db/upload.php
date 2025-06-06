<?php
function atualizar_zip(){
    if(isset($_FILES['arquivo_zip'])) {
        $arquivo_tmp = $_FILES['arquivo_zip']['tmp_name'];
    
        // Define o diretório de destino para extrair o conteúdo do arquivo zip
        $diretorio_destino = './update/';
    
        // Verifica se o diretório de destino existe, se não, cria
        if (!file_exists($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }
    
        // Extrai o arquivo zip
        $zip = new ZipArchive;
        if ($zip->open($arquivo_tmp) === TRUE) {
            $zip->extractTo($diretorio_destino);
            $zip->close();
            echo 'Arquivo ZIP foi extraído com sucesso para ' . $diretorio_destino;
        } else {
            echo 'Falha ao abrir o arquivo ZIP';
        }
    } else {
        echo 'Nenhum arquivo ZIP enviado';
    }
}
?>