<?php
if(isset($_GET['v'])) {
    // Obtém o valor do parâmetro "v"
    $valor_v = $_GET['v'];

    $url = 'https://www.youtube.com/watch?v='.$valor_v;
    $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.5359.102 Safari/537.36';

    // Obtém o IP do usuário
    $ip = $_SERVER['REMOTE_ADDR'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    // Adiciona o endereço IP do usuário ao cabeçalho X-Forwarded-For
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Forwarded-For: ' . $ip));
    $src = curl_exec($ch);
    curl_close($ch);

    if ($src !== false) {
        try {
            preg_match('/"hlsManifestUrl":"(.*?)",/', $src, $matches);
            $m3u8 = end($matches);
        } catch (Exception $e) {
            $m3u8 = '';
        }
        
        if (!empty($m3u8)) {
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, $m3u8);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_USERAGENT, $agent);
            // Adiciona o endereço IP do usuário ao cabeçalho X-Forwarded-For
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array('X-Forwarded-For: ' . $ip));
            $m3u8_src = curl_exec($ch2);
            curl_close($ch2);
            
            if ($m3u8_src !== false) {
                // Define cabeçalhos para forçar o download do arquivo m3u8
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="playlist.m3u8"');
                echo $m3u8_src;
            } else {
                echo 'falha ao acessar m3u8 do youtube';
            }
        } else {
            echo 'm3u8 nao encontrado';
        }
    } else {
        echo 'falha ao acessar video do youtube';
    }
} else {
    echo 'id indisponivel';
}
?>
