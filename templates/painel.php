<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Painel</title>
    <link rel="stylesheet" type="text/css" href= "css/default.css">
</head>
<script src="js/default.js"></script>

<body>
    <div class="title">
        <h1>Painel Vip</h1>
    </div>
    <div class="admin">
        <?php 
        if(isset($_SESSION["usuario"])){
           echo 'Você logou como <strong>'.$_SESSION["usuario"].'</strong>';
        }
        ?>        
    </div>
        <div class="menu">
            <a href="./">Home</a> | <a href="?action=logout">Sair</a> | <a href="?action=online">Usuarios Online</a> | <a href="?action=listas">Atualizar Listas</a> | <a href="?action=stalker">Atualizar Stalker</a> | <a href="?action=updateaddon">Update Spartan</a> | <a href="?action=adicionarvip">Adicionar Usuário VIP</a> | <a href="?action=adicionarteste">Adicionar Usuário TESTE</a> | <a href="?action=trocarsenha">Trocar Senha</a> | <a href="?action=deletar">Remover Usuário</a>| <a href="?action=pesquisar">Pesquisar Usuários</a> | <a href="?action=listar">Exibir Usuários</a> | <a href="?action=renovar">Renovar VIP</a> | <a href="?action=backup">Backup DB</a> | <a href="?action=restaurar">Restaurar DB</a>
        </div>
    <div class="corpo">
        <?php
        if (isset($msg)){
            echo $msg;
        }
        if (isset($action)){
            // controle do menu
            if ($action == 'listas'){
                echo '<style>';
                echo '.line-break {';
                echo '    display: block;';
                echo '}';
                echo '</style>';                
                echo '<h2>Atualizar Listas</h2>';
                echo '<div class="formlistas">';
                echo '  <h3>Converter e Salvar lista m3u</h3>';
                echo '  <form autocomplete="off" action="?action=updatelista" method="POST">';
                echo '      <label for="m3u_url">URL da Lista M3U:</label><br>';
                echo '      <input type="text" id="m3u_url" name="m3u_url" style="width: 500px; required>';
                echo '      <span class="line-break"></span>'; // Adiciona a quebra de linha                
                echo '      <br><label for="output_file">Nome do Arquivo de Saída:</label><br>'; // Movido para uma nova linha
                echo '      <select id="output_file" name="output_file" required>';
                echo '          <option value="lista1.m3u">lista1.m3u</option>';
                echo '          <option value="lista2.m3u">lista2.m3u</option>';
                echo '          <option value="lista3.m3u">lista3.m3u</option>';
                echo '          <option value="lista4.m3u">lista4.m3u</option>';
                echo '          <option value="lista5.m3u">lista5.m3u</option>';
                echo '          <option value="lista6.m3u">lista6.m3u</option>';
                echo '          <option value="lista7.m3u">lista7.m3u</option>';
                echo '          <option value="lista8.m3u">lista8.m3u</option>';
                echo '          <option value="lista9.m3u">lista9.m3u</option>';
                echo '          <option value="lista10.m3u">lista10.m3u</option>';
                echo '          <option value="lista11.m3u">lista11.m3u</option>';
                echo '          <option value="lista12.m3u">lista12.m3u</option>';
                echo '          <option value="lista13.m3u">lista13.m3u</option>';
                echo '          <option value="lista14.m3u">lista14.m3u</option>';
                echo '          <option value="lista15.m3u">lista15.m3u</option>';
                echo '          <option value="lista16.m3u">lista16.m3u</option>';
                echo '          <option value="lista17.m3u">lista17.m3u</option>';
                echo '          <option value="lista18.m3u">lista18.m3u</option>';
                echo '          <option value="lista19.m3u">lista19.m3u</option>';
                echo '          <option value="lista20.m3u">lista20.m3u</option>';
                echo '      </select><br><br>';
                echo '      <input type="submit" value="Salvar">';
                echo '  </form>';
                echo '</div>';
            }elseif ($action == 'stalker'){
                echo '<style>';
                echo '.line-break {';
                echo '    display: block;';
                echo '}';
                echo '</style>';                
                echo '<h2>Atualizar Listas Stalker</h2>';
                echo '<div class="formlistas">';
                echo '  <h3>Dados da Lista Stalker</h3>';
                echo '  <form autocomplete="off" action="?action=updatestalker" method="POST">';
                echo '      <label for="host_stalker">Server:</label>';
                echo '      <input type="text" id="host_stalker" name="host_stalker" placeholder="Exemplo: http://host.com:80" style="width: 200px; required><br>';
                echo '      <label for="mac_stalker">MAC Address:</label>';
                echo '      <input type="text" id="mac_stalker" name="mac_stalker" placeholder="Exemplo: 00:1A:79:A7:AE:D5" style="width: 190px; required>';
                echo '      <span class="line-break"></span>'; // Adiciona a quebra de linha                
                echo '      <br><label for="output_file">Nome do Arquivo de Saída:</label><br>'; // Movido para uma nova linha
                echo '      <select id="output_file" name="output_file" required>';
                echo '          <option value="lista1.txt">lista1.txt</option>';
                echo '          <option value="lista2.txt">lista2.txt</option>';
                echo '          <option value="lista3.txt">lista3.txt</option>';
                echo '          <option value="lista4.txt">lista4.txt</option>';
                echo '          <option value="lista5.txt">lista5.txt</option>';
                echo '          <option value="lista6.txt">lista6.txt</option>';
                echo '          <option value="lista7.txt">lista7.txt</option>';
                echo '          <option value="lista8.txt">lista8.txt</option>';
                echo '          <option value="lista9.txt">lista9.txt</option>';
                echo '          <option value="lista10.txt">lista10.txt</option>';
                echo '      </select><br><br>';
                echo '      <input type="submit" value="Salvar">';
                echo '  </form>';
                echo '</div>';                
            } elseif ($action == 'online'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    include 'ping/acessos.php';
                }                               
            } elseif ($action == 'updateaddon'){
                echo '<h2>Update Spartan</h2>';
                echo '<br>';
                echo '<a href="?action=uploadaddon">Upload do Spartan</a>';
            } elseif ($action == 'uploadaddon'){
                echo '<h2>Update Spartan</h2>';
                echo '<br>';
                echo '<h3>Upload Addon Spartan</h3>';
                echo '<br>';
                echo '<form action="?action=uploadzipaddon" method="post" enctype="multipart/form-data">';
                echo '  Selecione o arquivo ZIP para enviar:';
                echo '  <input type="file" name="arquivo_zip" id="arquivo_zip" accept=".zip">';
                echo '  <input type="submit" value="Enviar Arquivo ZIP" name="submit">';
                echo '</form>';         
            } elseif ($action == 'adicionarvip'){
                echo '<h2>Adicionar Usuario VIP</h2>';
                echo '<div class="formusuario">';
                echo '  <h3>Proibido caracteres especiais, vip dura um mês</h3>';
                echo '  <form autocomplete="off" action="?action=addvip" method="POST">';
                echo '      Usuario:  <input type="text" pattern="^[a-zA-Z0-9]+$" name="usernamevip" placeholder="Insira o usuário" required/>';
                echo '      Senha:  <input type="password" pattern="^[a-zA-Z0-9]+$" placeholder="Insira a senha" name="passwordvip" required/>';
                echo '      <button>Adicionar</button>';
                echo '  </form>';
                echo '</div>';
            } elseif ($action == 'adicionarteste'){
                echo '<h2>Adicionar Usuario TESTE</h2>';
                echo '<div class="formusuario">';
                echo '  <h3>Proibido caracteres especiais, vip dura 24 horas</h3>';
                echo '  <form autocomplete="off" action="?action=addteste" method="POST">';
                echo '      Usuario:  <input type="text" pattern="^[a-zA-Z0-9]+$" name="usernamevip" placeholder="Insira o usuário" required/>';
                echo '      Senha:  <input type="password" pattern="^[a-zA-Z0-9]+$" placeholder="Insira a senha" name="passwordvip" required/>';
                echo '      <button>Adicionar</button>';
                echo '  </form>';
                echo '</div>';
            } elseif ($action == 'trocarsenha'){
                echo '<h2>Trocar senha</h2>';
                echo '<div class="formpassword">';
                echo '<h3>Proibido caracteres especiais</h3>';
                echo '<form action="?action=changepassword" method="POST">';
                if (isset($usernamevip)){
                    echo 'Trocar senha de: '.$usernamevip;
                    echo '<br>';
                    echo '<input type="hidden" name="usernamevip" value="'.$usernamevip.'">';
                } else {
                    echo 'Usuário: <input type="text" pattern="^[a-zA-Z0-9]+$" placeholder="Insira o usuário" name="usernamevip" required/>';
                }
                echo 'Nova senha: <input type="password" pattern="^[a-zA-Z0-9]+$" placeholder="Insira a nova senha" name="passwordvip" required/>';
                echo '<button>Salvar</button>';
                echo '</form>';
                echo '</div>';
            } elseif ($action == 'deletar'){
                echo '<h2>Remover Usuário</h2>';
                echo '<div class="formdeletar">';
                echo '  <form action="?action=removeruser" method="POST">';
                echo '      Usuário:  <input type="text" pattern="^[a-zA-Z0-9]+$" placeholder="Usuário a ser removido" name="usernamevip" required/>';
                echo '      <button>Remover</button>';
                echo '  </form>';
                echo '</div>';
            } elseif ($action == 'renovar'){
                echo '<h2>Renovar VIP</h2>';
                echo '<div class="formrenovar">';
                echo '  <form action = "?action=renovarvip" method="POST">';
                echo '      Usuário:  <input type="text" pattern="^[a-zA-Z0-9]+$" placeholder="Usuário a ser renovado" name="usernamevip" required/>';
                echo '      <button>Renovar</button>';
                echo '  </form>';
                echo '</div>';
            } elseif ($action == 'pesquisar'){
                echo '<h2>Pesquisar Usuário</h2>';
                echo '<div class="formpesquisar">';
                echo '<h3>Proibido caracteres especiais</h3>';
                echo '<form action = "./" method="GET">';
                echo '  <input type="hidden" name="action" value="listar">';
                echo '  Usuario:  <input type="text" pattern="^[a-zA-Z0-9]+$" name="usernamevip" placeholder="Insira o usuário para pesquisar" required/>';
                echo '  <button>Pesquisar</button>';
                echo '</form>';
                echo '</div>';
            } elseif ($action == 'listar'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    include 'db/manager.php';
                    if (isset($usernamevip)){                    
                        exibir_usuarios2($usernamevip,$db);
                    } else {
                        exibir_usuarios($db);
                    }
                }
            // comeca as funções principais
            } elseif ($action == 'addvip'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    if (isset($usernamevip) && isset($passwordvip)){
                        include 'db/manager.php';
                        adicionar_usuario($usernamevip,$passwordvip,$db);
                    } else {
                        echo 'Dados invalidos!';
                    }
                }
            } elseif ($action == 'addteste'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    if (isset($usernamevip) && isset($passwordvip)){
                        include 'db/manager.php';
                        adicionar_usuario_teste($usernamevip,$passwordvip,$db);
                    } else {
                        echo 'Dados invalidos!';
                    }
                }
            } elseif ($action == 'changepassword'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    if (isset($usernamevip) && isset($passwordvip)){
                        include 'db/manager.php';
                        mudar_senha($usernamevip,$passwordvip,$db);
                    } else {
                        echo 'Dados invalidos!';
                    }
                }
            } elseif ($action == 'removeruser'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    if (isset($usernamevip)){
                        include 'db/manager.php';
                        deletar_usuario($usernamevip,$db);
                    } else {
                        echo 'Dados invalidos!';
                    }
                }
            } elseif ($action == 'renovarvip'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    if (isset($usernamevip)){
                        include 'db/manager.php';
                        renovar_vip($usernamevip,$db);
                    } else {
                        echo 'Dados invalidos!';
                    }
                }
            } elseif ($action == 'backup'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    echo '<h2>Download Database</h2><br><br>';
                    echo '<a href="?action=downloaddb"><img src="images/database.png" height="42" width="42"><br>Clique aqui para baixar o database</a>';
                }           
            } elseif ($action == 'restaurar'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    echo '<h2>Restaurar Database</h2>';
                    echo '<div class="formupload">';
                    echo '<h3>Aviso os dados anteriores serão apagados!</h3><br>';
                    echo '<form action="?action=upload" method="post" enctype="multipart/form-data">';
                    echo '  Selecione o arquivo: <input type="file" name="arquivo" accept=".db"/>';
                    echo '  <input type="submit" value="Enviar"/>';
                    echo '</form>';
                }
            } elseif ($action == 'updatelista'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    include 'db/list_converter.php';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Obter a URL da lista M3U do formulário
                        $m3u_url = $_POST['m3u_url'];
                        // Obter o nome do arquivo do formulário
                        $output_file = $_POST['output_file'];
                        // Chamar a função para remover canais de mídia da lista M3U
                        remove_media_channels($m3u_url, $output_file);

                    } else {
                        echo 'Houve algum problema, tente outra vez';
                    }
                }
            } elseif ($action == 'updatestalker'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    include 'db/list_stalker.php';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $host_stalker = htmlspecialchars($_POST['host_stalker']);
                        $mac_stalker = htmlspecialchars($_POST['mac_stalker']);
                        $output_file = $_POST['output_file'];
                        salvar_stalker($host_stalker,$mac_stalker,$output_file);
                    } else {
                        echo 'Houve algum problema, tente outra vez';
                    }
                }                
            } elseif ($action == 'uploadzipaddon'){
                if(isset($_SESSION["usuario"]) && isset($_SESSION["painel_token"])){
                    include 'db/upload.php';

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        atualizar_zip();
                    } else {
                        echo 'Houve algum problema, tente outra vez';
                    }
                }
            }
        }
        ?>
    </div>

    <div class="footer">
        <p>Desenvolvido por: Joel Silva, <a href="?action=pix">Doar via PIX</a></p>
    </div>
</body>
</html>