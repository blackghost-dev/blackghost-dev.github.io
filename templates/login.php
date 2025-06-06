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
    <div class="login-page">
        <div class="form">
            <form class="login-form" action="?action=login" method="POST">
                <input type="text" pattern="^[a-zA-Z0-9]+$" placeholder="Seu usuario" name="username" required/>
                <input type="password" pattern="^[a-zA-Z0-9]+$" placeholder="Sua senha" name="password" required/>
                <button>login</button>
                <?php 
                    if(isset($msg)){
                    echo '<div class="message">'.$msg.'</div>';
                    }                               
                ?>        
            </form>
        </div>
    </div>

    <div class="footer">
        <p>Desenvolvido por: Joel Silva, <a href="?action=pix">Doar via PIX</a></p>
    </div>
</body>
</html>