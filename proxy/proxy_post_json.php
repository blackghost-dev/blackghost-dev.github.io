<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém a URL e os parâmetros POST do usuário
    $url = $_POST['url'];
    $jsonParams = $_POST['json'];

    // Converte os dados para JSON
    //$jsonParams = json_encode($postData);    

    // Inicializa cURL
    $ch = curl_init($url);

    // Configura as opções do cURL para método POST, parâmetros e User-Agent do Chrome
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonParams);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Habilita o suporte a redirecionamentos
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if (isset($_SERVER['HTTP_REFERER'])) {
        // Obtém o Referer do cabeçalho da solicitação do usuário
        $referer = $_SERVER['HTTP_REFERER'];
        // Define o Referer no cabeçalho da solicitação
        curl_setopt($ch, CURLOPT_REFERER, $referer);
    }
    // Verifica se o User-Agent existe no cabeçalho da solicitação do usuário
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        // Obtém o User-Agent do navegador do usuário
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        // Define o User-Agent no cabeçalho da solicitação
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    } else {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonParams)
    ));

    // Executa a requisição cURL e obtém a resposta
    $response = curl_exec($ch);

    // Obtém o código de resposta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Verifica se o código de resposta é 200 e exibe o HTML
    if ($httpCode == 200) {
        echo $response;
    } else {
        echo "Erro na requisição. Código de resposta: $httpCode\n";
        echo "Erro cURL: " . curl_error($ch);
        echo "URL: $url\n";
        echo "Dados JSON: $jsonParams\n";
    }
    // Fecha a sessão cURL
    curl_close($ch);    
} else {
    echo 'Envie usando metodo post';
}
?>
