<?php
function remove_media_channels($m3u_url, $output_file) {
    // Configurações do cabeçalho para simular uma solicitação do Chrome
    $headers = [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36'
    ];

    // Configurações do cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $m3u_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Adiciona cabeçalhos personalizados
    $m3u_content = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtém o código de resposta HTTP
    curl_close($ch);

    // Verificar se o código de resposta HTTP é 200 (OK)
    if ($http_code == 200) {
        // Dividir as linhas da lista M3U
        $lines = explode("\n", $m3u_content);

        // Array para armazenar as linhas atualizadas da lista M3U
        $updated_m3u_data = ['#EXTM3U'];

        foreach ($lines as $key => $line) {
            if (strpos($line, '#EXTINF') === 0) {
                $next_line = isset($lines[$key + 1]) ? trim($lines[$key + 1]) : '';
                if (!preg_match('/\.(mkv|avi|mp4)$/', $next_line)) {
                    $updated_m3u_data[] = $line;
                    $updated_m3u_data[] = $next_line;
                }
            }
        }

        // Salvar o resultado com o nome de arquivo fornecido
        file_put_contents('./listas/'.$output_file, implode("\n", $updated_m3u_data));
        echo 'Arquivo atualizado com sucesso como ' . $output_file;
    } else {
        echo 'Não foi possível salvar o arquivo. Código de resposta HTTP: ' . $http_code;
    }
}


function test($output_file) {
    file_put_contents('./listas/'.$output_file, 'teste teste');
    echo 'teste gravado';
}
?>