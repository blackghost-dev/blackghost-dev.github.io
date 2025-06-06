<?php

ini_set('max_execution_time', 0);

if (!isset($_SESSION)) session_start();

if(isset($_GET['action'])){
    $action = $_GET['action'];
} elseif(isset($_POST['action'])){
    $action = $_POST['action'];
} else {
    $action = '';
}

if(isset($_GET['usernamevip'])){
    $usernamevip = $_GET['usernamevip'];
} elseif(isset($_POST['usernamevip'])){
    $usernamevip = $_POST['usernamevip'];
}

if(isset($_GET['passwordvip'])){
    $passwordvip = $_GET['passwordvip'];
} elseif(isset($_POST['passwordvip'])){
    $passwordvip = $_POST['passwordvip'];
}

switch ($action) {
    case 'pix':
        include 'templates/pix.php';
        break;
    case 'login':
        if(isset($_POST['username']) && isset($_POST['password'])){
            include 'db/manager.php';
            $usuario = $_POST['username'];
            $senha = $_POST['password'];
            list($return_usuario,$return_tipo) = checar_login($usuario,$senha,$db);
            if (isset($return_usuario)){
                if ($return_tipo == 'admin'){
                    $_SESSION["usuario"] = $return_usuario;
                    $_SESSION["painel_token"] = hash('sha256', $return_usuario).hash('sha256', $return_tipo);
                    header("Location: ./");
                } else {
                    $msg = 'Você não é admin!';
                    include 'templates/login.php';
                }
            } else {
                $msg = 'Usuário não existe!';
                include 'templates/login.php';
            }
        } else {
            $msg = 'Dados invalidos!';
            include 'templates/login.php';
        }
        break;
    case 'logout':
        session_destroy();
        header("Location: ./");
    case 'acesso':
        //if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['url'])){
        if(isset($_GET['username']) && isset($_GET['password'])){
            //admin - http://localhost/painelvip/?action=acesso&username=YWRtaW4%3D&password=MTIz&url=aHR0cHM6Ly9nb29nbGUuY29tLmJyLw%3D%3D
            //teste - http://localhost/painelvip/?action=acesso&username=dGVzdGU%3D&password=MTIz&url=aHR0cHM6Ly9nb29nbGUuY29tLmJyLw%3D%3D
            include 'db/manager.php';
            $username_acesso = $_GET['username'];
            $password_acesso = $_GET['password'];
            //$url_acesso = $_GET['url'];
            $username_decode = base64_decode($username_acesso);
            $password_decode = base64_decode($password_acesso);
            //$url_decode = base64_decode($url_acesso);
            $cond = acesso_usuario($username_decode,$password_decode,$db);
            if ($cond !=false){
                header("Content-Type: text/plain");
                //$html = browser($url_decode);
                //echo $html;
                echo 'ativado';
            } else {
                header("Content-Type: text/plain");
                echo 'expirado';
            } 
        } else {
            header("Content-Type: text/plain");
            echo 'expirado';
        }
        break;
    case 'vencimento':
        if(isset($_GET['username']) && isset($_GET['password'])){
            //admin - http://localhost/painelvip/?action=vencimento&username=YWRtaW4%3D&password=MTIz
            // teste - http://localhost/painelvip/?action=vencimento&username=dGVzdGU%3D&password=MTIz
            include 'db/manager.php';
            $username_acesso = $_GET['username'];
            $password_acesso = $_GET['password'];
            $username_decode = base64_decode($username_acesso);
            $password_decode = base64_decode($password_acesso);
            $vencimento = vencimento_login($username_decode,$password_decode,$db);
        } else {
            $vencimento = 'desconhecido';
        }
        header("Content-Type: text/plain");
        echo $vencimento;
        break;
    case 'downloaddb':
        if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
            include 'db/manager.php';
            download($pathdb);
        } else {
            header("Location: ./");
        }
        break;
    case 'upload':
        if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
            include 'db/manager.php';
            $msg = upload_db();
            include 'templates/painel.php'; 
        } else {
            header("Location: ./");
        }
        break;
    default:
        if(!isset($_SESSION["usuario"]) && !isset($_SESSION["painel_token"])){
            // Usuário não logado! Redireciona para a página de login
            //header("Location: login.html");
            include 'templates/login.php';
        } else {
            include 'templates/painel.php';       
        }
        break;
}


?>