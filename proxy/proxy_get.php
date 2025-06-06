<?php
if (isset($_GET['url'])) {
    // Obtém a URL fornecida como parâmetro
    $url = $_GET['url'];
    // Decodifica a URL, se ela estiver codificada
    $url = urldecode($url);
    // Divide a URL em partes
    $urlParts = parse_url($url);
    // Verifica se há parâmetros de consulta na URL
    if (isset($urlParts['query'])) {
        // Analisa os parâmetros de consulta
        parse_str($urlParts['query'], $queryParams);

        // Adiciona os parâmetros de consulta à URL base
        $baseUrl = $urlParts['scheme'] . '://' . $urlParts['host'] . $urlParts['path'];
        $fullUrl = $baseUrl . '?' . http_build_query($queryParams);
    } else {
        // Se não houver parâmetros de consulta, usa a URL original
        $fullUrl = $url;
    }        
    // Inicializa uma sessão cURL
    $ch = curl_init();
    // Define a URL de destino
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
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
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7,es;q=0.6'));
    // Define a opção para retornar o resultado como uma string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    // Executa a solicitação cURL e armazena a resposta na variável $output
    $output = curl_exec($ch); 
    // Verifica o código de resposta HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode == 200) {
        echo $output;
    } else {
        echo 'Erro ao acessar a URL. Código de resposta: ' . $httpCode;
    }
    // Fecha a sessão cURL
    curl_close($ch); 
} else {
    echo 'Parametro url não encontrado';      
}
?>