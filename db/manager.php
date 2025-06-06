<?php

include 'conn.php';

function checar_pra_inserir($usuario,$db) {
    if($db != false){
        $sql = "SELECT * FROM login WHERE usuario = '$usuario'";
        $res = $db->query($sql);
        $row = $res->fetchArray();
        if(empty($row)){
            $total = 0;
        } else {
            $total = count($row);
        }       

    } else {
        $total = 0;
    }
    if ($total > 1){
        return true;
    } else {
        return false;
    }

}

function checar_admin($usuario,$db) {
    if($db != false){
        $sql = "SELECT * FROM login WHERE usuario = '$usuario' AND tipo = 'admin'";
        $res = $db->query($sql);
        $row = $res->fetchArray();
        if(empty($row)){
            $total = 0;
        } else {
            $total = count($row);
        }       

    } else {
        $total = 0;
    }
    if ($total > 1){
        return true;
    } else {
        return false;
    }    

}

function inserir_usuario($usuario,$senha,$expira,$tipo,$vencimento,$db) {
    if($db != false){
        $existe = checar_pra_inserir($usuario,$db);
        if ($existe != true) {
            $sql = "INSERT INTO login(usuario, senha, expira, tipo, vencimento) VALUES('$usuario', '$senha', '$expira', '$tipo', '$vencimento')";
            $db->exec($sql);
            return true;
        } else {
            return false;
        }
    
    } else {
        return false;
    }

}    


function atualizar_usuario($usuario,$expira,$vencimento,$db) {
    if($db != false){
        $sql = "UPDATE login SET expira = '$expira', vencimento = '$vencimento' WHERE usuario = '$usuario'";
        $db->exec($sql);
    }
}

function atualizar_senha($usuario,$senha,$db) {
    if($db != false){
        $sql = "UPDATE login SET senha = '$senha' WHERE usuario = '$usuario'";
        $db->exec($sql);
    }
}

function atualizar_vip($usuario,$expira,$vencimento,$db) {
    if($db != false){
        $sql = "UPDATE login SET expira = '$expira', vencimento = '$vencimento' WHERE usuario = '$usuario'";
        $db->exec($sql);
        return true;
    } else {
        return false;
    }
}

function deletar_usuario($usuario,$db) {
    if($db != false){
        $existe = checar_admin($usuario,$db);
        if ($existe != true) {
            $sql = "DELETE FROM login WHERE usuario = '$usuario'";
            $db->exec($sql);
            echo 'Usuario: '.$usuario.' removido com sucesso!';
        } else {
            echo 'Usuário é admin e não pode ser removido!';
        }    
    } else {
        echo 'Falha ao remover usuário!';
    }
}

function login_usuario($usuario,$senha,$db){
    if($db != false){
        $sql = "SELECT * FROM login WHERE usuario = '$usuario' AND senha = '$senha'";
        $res = $db->query($sql);
        if(empty($row = $res->fetchArray())){
            $total = 0;
        } else {
            $total = count($row);
        }    

    } else {
        $total = 0;
    }
    if ($total > 1){
        return $res;
    } else {
        return false;
    }

}
// inicia aqui

function checar_login($usuario,$senha,$db){
    $return_usuario = '';
    $return_tipo = '';
    if($db != false){
        $senha_sha256 = hash('sha256', $senha);
        $sql = "SELECT * FROM login WHERE usuario = '$usuario' AND senha = '$senha_sha256'";
        $res = $db->query($sql);
        $i = 0;
        while ($row = $res->fetchArray()){
            $i++;
            if ($i == 1){
                $return_usuario = $row['usuario'];
                $return_tipo = $row['tipo'];
                break;
            }
        }
    }
    return array($return_usuario,$return_tipo);
}

function mudar_senha($usuario,$senha,$db){
    if($db != false){
        $senha_sha256 = hash('sha256', $senha);
        atualizar_senha($usuario,$senha_sha256,$db);
        echo 'Senha de '.$usuario.' atualizada com sucesso!';
    } else {
        echo 'Falha ao atualizar senha!';
    }
}

function tempo_vip(){
    date_default_timezone_set('America/Sao_Paulo');
    //$data_pagamento = date('Y-m-d H:i:s' , strtotime('+1 hours'));
    //$tempovip = date('YmdHi' , strtotime('+30 days'));
    $tempovip = date('YmdHi' , strtotime('+1 month'));
    //$vencimento = date('d/m/Y H:i' , strtotime('+30 days'));
    $vencimento = date('d/m/Y H:i' , strtotime('+1 month'));
    return array($tempovip,$vencimento);
}

function tempo_teste(){
    date_default_timezone_set('America/Sao_Paulo');
    $tempoteste = date('YmdHi' , strtotime('+24 hours'));
    $vencimento = date('d/m/Y H:i' , strtotime('+24 hours'));
    return array($tempoteste,$vencimento);
}

function tempo_atual(){
    date_default_timezone_set('America/Sao_Paulo');
    $tempo_atual = date('YmdHi');
    //$vencimento = date('d/m/Y H:i' , strtotime('+24 hours'));
    return $tempo_atual;
}

function checar_tempo($expire){
    $t = tempo_atual();
    if ($expire == 0){
        return true;
    } elseif ((int)$expire >= (int)$t){
        return true;
    } else {
        return false;
    }
}

function condicao_vip($expire){
    $cond = checar_tempo($expire);
    if ($expire == 0){
        return 'Infinito';
    }elseif ($cond !=false){
        return 'Ativo';
    } else {
        return 'Expirado';
    }
}

//listar usuarios
function exibir_usuarios($db) {
    if($db != false){
        $sql = "SELECT * FROM login";
        $res = $db->query($sql);
        echo '<h2>Lista de Usuários</h2>';
        echo '<ul>';
        while ($row = $res->fetchArray()){
           //echo $row['usuario'];
           echo '<li><p>Usuário: '.$row['usuario'].', Vip: '.condicao_vip($row['expira']).', Vencimento: '.$row['vencimento'].' | <a href="?action=renovarvip&usernamevip='.$row['usuario'].'">Renovar VIP</a> | <a href="?action=trocarsenha&usernamevip='.$row['usuario'].'">Trocar senha</a> | <a href="?action=removeruser&usernamevip='.$row['usuario'].'">Remover</a></p></li>';
        }
        echo '</ul>';
    } else {
        echo 'Nehum usuário encontrado!';
    }
}

function exibir_usuarios2($usuario,$db) {
    if($db != false){
        $sql = "SELECT * FROM login WHERE usuario LIKE '%".$usuario."%' ORDER BY usuario";
        $res = $db->query($sql);
        echo '<h2>Lista de Usuários</h2>';
        echo '<ul>';
        while ($row = $res->fetchArray()){
            echo '<li><p>Usuário: '.$row['usuario'].', Vip: '.condicao_vip($row['expira']).', Vencimento: '.$row['vencimento'].' | <a href="?action=renovarvip&usernamevip='.$row['usuario'].'">Renovar VIP</a> | <a href="?action=trocarsenha&usernamevip='.$row['usuario'].'">Trocar senha</a> | <a href="?action=removeruser&usernamevip='.$row['usuario'].'">Remover</a></p></li>';
        }
        echo '</ul>';
    } else {
        echo 'Nehum usuário encontrado!';
    }
}

function adicionar_usuario($usuario,$senha,$db){
    if($db != false){
        list($tempovip,$vencimento) = tempo_vip();
        $senha_sha256 = hash('sha256', $senha);
        $cond = inserir_usuario($usuario,$senha_sha256,$tempovip,'vip',$vencimento,$db);
        if($cond != false){
            echo 'Usuário '.$usuario.' adicionado com sucesso!';
        } else {
            echo 'Falha ao adicionar usuário!';
        }
    } else {
        echo 'Falha ao adicionar usuário!';
    }

}

function adicionar_usuario_teste($usuario,$senha,$db){
    if($db != false){
        list($tempoteste,$vencimento) = tempo_teste();
        $senha_sha256 = hash('sha256', $senha);
        $cond = inserir_usuario($usuario,$senha_sha256,$tempoteste,'vip',$vencimento,$db);
        if($cond != false){
            echo 'Usuário '.$usuario.' adicionado com sucesso!';
        } else {
            echo 'Falha ao adicionar usuário!';
        }
    } else {
        echo 'Falha ao adicionar usuário!';
    }

}

function vencimento_login($usuario,$senha,$db){
    $vencimento = 'desconhecido';
    if($db != false){
        $senha_sha256 = hash('sha256', $senha);
        $sql = "SELECT * FROM login WHERE usuario = '$usuario' AND senha = '$senha_sha256'";
        $res = $db->query($sql);
        $i = 0;
        while ($row = $res->fetchArray()){
            $i++;
            if ($i == 1){
                $vencimento = $row['vencimento'];
                break;
            }
        }
    }
    return $vencimento;
}

function acesso_usuario($usuario,$senha,$db){
    $cond = false;
    if($db != false){
        $senha_sha256 = hash('sha256', $senha);
        $sql = "SELECT * FROM login WHERE usuario = '$usuario' AND senha = '$senha_sha256'";
        $res = $db->query($sql);
        $i = 0;
        while ($row = $res->fetchArray()){
            $i++;
            if ($i == 1){
                $expira = $row['expira'];
                $cond = checar_tempo($expira);
                break;
            }
            
        }
    }
    return $cond;
}

// function renovar_vip($usuario,$db){
//     if($db != false){
//         list($tempovip,$vencimento) = tempo_vip();
//         $existe = checar_admin($usuario,$db);
//         if ($existe !=true){
//             $ok = atualizar_vip($usuario,$tempovip,$vencimento,$db);
//             if ($ok !=false){
//                 echo 'Vip de '.$usuario.' renovado!';
//             } else {
//                 echo 'falha ao renovar vip!';
//             }
//         } else {
//             echo 'Usuário já é admin e tem vip infinito!';
//         }
//     } else {
//         echo 'Falha ao renovar vip!';
//     }
// }

function renovar_vip($usuario, $db) {
    date_default_timezone_set('America/Sao_Paulo');
    if($db != false){
        $sql = "SELECT * FROM login WHERE usuario = '$usuario'";
        $res = $db->query($sql);
        $row = $res->fetchArray();
        if($row){
            $expira = $row['expira'];
            //$vencimento = $row['vencimento'];
            $expira_timestamp = strtotime($expira); // Convertendo para timestamp
            //$vencimento_timestamp = strtotime($vencimento); // Convertendo para timestamp
            $vencimento_timestamp = $expira_timestamp;
            $atual_timestamp = strtotime("now"); // Timestamp atual
            if ($expira_timestamp > $atual_timestamp || $vencimento_timestamp > $atual_timestamp) {
                // Se a expiração atual ou o vencimento for maior que a data atual
                // Adiciona 30 dias à data de expiração e de vencimento
                //$nova_expiracao = date('YmdHi', strtotime('+30 days', $expira_timestamp));
                $nova_expiracao = date('YmdHi', strtotime('+1 Month', $expira_timestamp));
                //$novo_vencimento = date('d/m/Y H:i', strtotime('+30 days', $vencimento_timestamp));
                $novo_vencimento = date('d/m/Y H:i', strtotime('+1 Month', $vencimento_timestamp));
            } else {
                // Se a expiração já passou ou é igual à data atual
                // Define a expiração para 30 dias a partir de agora
                list($nova_expiracao, $novo_vencimento) = tempo_vip();
            }
            $ok = atualizar_vip($usuario, $nova_expiracao, $novo_vencimento, $db);
            if ($ok != false) {
                echo 'Vip de ' . $usuario . ' renovado!';
            } else {
                echo 'Falha ao renovar vip!';
            }
        } else {
            echo 'Usuário não encontrado!';
        }
    } else {
        echo 'Falha ao renovar vip!';
    }
}


function browser($url) {
	$curl = curl_init();	
	$headers = [
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
		'Cache-Control: max-age=0',
		'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7'
		//'X-Forwarded-For: '.$_SERVER['REMOTE_ADDR']
		];
	//opcaional
	//curl_setopt($curl, CURLOPT_PROXY, $proxy);
	//curl_setopt($curl, CURLOPT_PROXYPORT, $port);
	///////////////////////////////////////////////
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84 Safari/537.36");
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	//curl_setopt($curl, CURLOPT_REFERER, $referer);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	//curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 15);
	//if (!$html = curl_exec($curl)) { $html = file_get_contents($url); }
	$html = curl_exec($curl);
	curl_close($curl);
	return $html;
}

function download($pathdb){
    if(isset($pathdb) && file_exists($pathdb)){
        // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
           switch(strtolower(substr(strrchr(basename($pathdb),"."),1))){
           // verifica a extensão do arquivo para pegar o tipo
              case "pdf": $tipo="application/pdf"; break;
              case "exe": $tipo="application/octet-stream"; break;
              case "zip": $tipo="application/zip"; break;
              case "doc": $tipo="application/msword"; break;
              case "xls": $tipo="application/vnd.ms-excel"; break;
              case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
              case "gif": $tipo="image/gif"; break;
              case "png": $tipo="image/png"; break;
              case "jpg": $tipo="image/jpg"; break;
              case "mp3": $tipo="audio/mpeg"; break;
              case "db": $tipo="application/vnd.sqlite3"; break;
              case "php": // deixar vazio por seurança
              case "htm": // deixar vazio por seurança
              case "html": // deixar vazio por seurança
           }
           header("Content-Type: ".$tipo);
           // informa o tipo do arquivo ao navegador
           header("Content-Length: ".filesize($pathdb));
           // informa o tamanho do arquivo ao navegador
           header("Content-Disposition: attachment; filename=".basename($pathdb));
           // informa ao navegador que é tipo anexo e faz abrir a janela de download,
           //tambem informa o nome do arquivo
           readfile($pathdb); // lê o arquivo
           exit; // aborta pós-ações
        }
}

function upload_db(){
    $dir = "db/"; 
    // recebendo o arquivo multipart 
    $file = $_FILES["arquivo"];
    $extension = strtolower(substr(strrchr(basename($file["name"]),"."),1));
    if ($extension == 'db'){
        $nome_db = 'users.db';
        //if (move_uploaded_file($file["tmp_name"], "$dir/".$file["name"])) {
        if (move_uploaded_file($file["tmp_name"], "$dir/".$nome_db)) {
            $msg = 'Backup restaurado com sucesso!';
        } else {
            $msg = 'Falha ao enviar backup!';
        }
    } else {
        $msg = 'Extensão invalida!';
    } 
    return $msg;
}

?>