<?php

try {
    // Caminho para o banco de dados SQLite (relativo à pasta 'ping')
    $dbPath = __DIR__ . '/../db/contador.db';

    // Verifica se o arquivo do banco de dados existe
    if (!file_exists($dbPath)) {
        throw new Exception("Banco de dados não encontrado.");
    }

    // Conecta ao banco de dados SQLite
    $db = new SQLite3($dbPath);

    // Obter a data e hora atuais
    $now = new DateTime();

    // Consulta para obter todos os registros
    $result = $db->query("SELECT id, ip_address, count, last_ping FROM contador");
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $ip_address = $row['ip_address'];
        $last_ping = new DateTime($row['last_ping']);

        // Calcular a diferença de tempo em minutos
        $interval = $now->diff($last_ping);
        $minutes_passed = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

        // Verificar se mais de 100 minutos se passou desde o último ping
        if ($minutes_passed > 100) {
            // Remover o registro
            $stmt = $db->prepare("DELETE FROM contador WHERE id = :id");
            $stmt->bindValue(':id', $row['id'], SQLITE3_INTEGER);
            $stmt->execute();
        }
    }

    // Consulta para obter o total de acessos após a atualização
    $result = $db->query("SELECT SUM(count) AS total_acessos FROM contador");
    $row = $result->fetchArray(SQLITE3_ASSOC);

    // Obtém o total de acessos
    $total_acessos = $row['total_acessos'] ?? 0;

    // Retorna o total de acessos
    echo "Total Online no Addon Spartan: $total_acessos";

} catch (Exception $e) {
    // Em caso de erro, exibir total online como 0
    echo "Total Online no Addon Spartan: 0";
}
?>
