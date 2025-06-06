<?php

function salvar_stalker($host_url,$mac,$output_file){
    $host_stalker = $host_url;
    $mac_stalker = $mac;
    // Formatar os dados
    $conteudo = "<host>{$host_stalker}</host>\n<mac>{$mac_stalker}</mac>\n";
    // Caminho do arquivo
    $arquivo = './stalker/'.$output_file;
    file_put_contents($arquivo, $conteudo);
    echo 'Lista gravada com sucesso em '.$output_file;

}
?>