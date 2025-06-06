<?php
	//check if the database file exists and create a new if not
if(!is_file('./db/users.db')){
	$db = new SQLite3('./db/users.db') or die("falha ao criar database!");
	$db->exec("CREATE TABLE IF NOT EXISTS login(usuario TEXT, senha TEXT, expira NUMERIC, tipo TEXT, vencimento TEXT)");
	$usuario = 'admin';
	$senha = hash('sha256', '123');
	$expira = 0;
	$tipo = 'admin';
	$vencimento = 'indeterminado';
	$db->exec("INSERT INTO login(usuario, senha, expira, tipo, vencimento) VALUES('$usuario', '$senha', '$expira', '$tipo', '$vencimento')");
	$pathdb = './db/users.db';
} elseif(is_file('./db/users.db')){
	$db = new SQLite3('./db/users.db') or die("falha ao conectar no database!");
	$pathdb = './db/users.db';
} else {
	$db = false;
	$pathdb = './db/users.db';
}


?>
