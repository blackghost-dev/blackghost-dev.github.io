<?php

// Caminho para o banco de dados SQLite (relativo à pasta 'ping')
$dbPath = __DIR__ . '/../db/contador.db';

// Conecta ao banco de dados SQLite
$db = new SQLite3($dbPath) or die("Falha ao criar database!");

// Cria a tabela se não existir
$db->exec("CREATE TABLE IF NOT EXISTS contador (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip_address TEXT NOT NULL,
    count INTEGER NOT NULL,
    last_ping TIMESTAMP NOT NULL
)");

// Obter o endereço IP do usuário
$ip_address = $_SERVER['REMOTE_ADDR'];

// Obter o registro do contador para o IP específico
$stmt = $db->prepare("SELECT count, last_ping FROM contador WHERE ip_address = :ip_address");
$stmt->bindValue(':ip_address', $ip_address, SQLITE3_TEXT);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

// Obter a data e hora atuais
$now = new DateTime();

if ($row) {
    $last_ping = new DateTime($row['last_ping']);
    
    // Calcular a diferença de tempo em minutos
    $interval = $now->diff($last_ping);
    $minutes_passed = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

    // Verificar se mais de 100 minutos se passou desde o último ping
    if ($minutes_passed > 100) {
        // Resetar o contador
        $stmt = $db->prepare("UPDATE contador SET count = 0, last_ping = :last_ping WHERE ip_address = :ip_address");
        $stmt->bindValue(':last_ping', $now->format('Y-m-d H:i:s'), SQLITE3_TEXT);
        $stmt->bindValue(':ip_address', $ip_address, SQLITE3_TEXT);
        $stmt->execute();
    } else {
        // Atualizar o timestamp do último ping
        $stmt = $db->prepare("UPDATE contador SET last_ping = :last_ping WHERE ip_address = :ip_address");
        $stmt->bindValue(':last_ping', $now->format('Y-m-d H:i:s'), SQLITE3_TEXT);
        $stmt->bindValue(':ip_address', $ip_address, SQLITE3_TEXT);
        $stmt->execute();
    }
} else {
    // Caso não tenha encontrado o registro, inicializa os valores
    $stmt = $db->prepare("INSERT INTO contador (ip_address, count, last_ping) VALUES (:ip_address, 1, :last_ping)");
    $stmt->bindValue(':ip_address', $ip_address, SQLITE3_TEXT);
    $stmt->bindValue(':last_ping', $now->format('Y-m-d H:i:s'), SQLITE3_TEXT);
    $stmt->execute();
}

// Retornar o valor atualizado
#echo "Contador para o IP $ip_address: $current_count";
?>
