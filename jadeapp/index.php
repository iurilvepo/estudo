<!DOCTYPE html>
<html lang="pt-Br">
<head>  	
	<link rel="shortcut icon" type="imagex/png" href="img/iconabas.png">
	<link rel="apple-touch-icon" sizes="180x180" href="img/iconabas.png">
	<link rel="icon" type="image/png" sizes="32x32" href="img/iconabas.png">
	<link rel="icon" type="image/png" sizes="16x16" href="img/iconabas.png">

	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#ffffff">
	<link rel="manifest" href="/manifest.json">

	<title>Jade</title>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100%;
            width: 100%;
        }
        .app-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
            background-color: #f5f5f5;
        }
        h1 {
            font-size: 2rem;
            color: #333;
        }
        button {
            padding: 10px 20px;
            font-size: 1rem;
            margin-top: 20px;
        }
        #alert{
            color: #B0C4DE;
        }
    </style>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="styles.css">

  </head>
    <body>

    <div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">

    </br> </br>
                <h3>Login</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><img src="img/iconabas.png" width="90"></span>
				</div>

    	<!-- start Login box -->
        <div class="card-body">	    	 

            <form action="" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="email" class="form-control" placeholder="E-mail" name="email" id="email" class="input-field" required/>
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="Senha" name="senha" id="senha" required/>
					</div>
    </br>
					<div class="form-group">
						<input type="submit" value="Login" class="btn float-right login_btn" name="btn-entrar">
					</div>
				</form>
			</div>

           
<center>
<?php
        
    require_once "logar.php";
               
    if( isset($_POST['btn-entrar']) ){// botao cadastrar

        // // pegando input
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);
        
        // // // // inserindo
        $logar = new Login();
        $logar-> logar($email,$senha);
   
    }

?>
</center>	
	
		</div>			        	
	</div>
</div>
<!--    CONVERTE EM MOBILE	        
	<script>
        document.addEventListener('DOMContentLoaded', () => {
            function enterFullScreen() {
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari and Opera
                        document.documentElement.webkitRequestFullscreen();
                    } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                        document.documentElement.msRequestFullscreen();
                    } else if (document.documentElement.webkitEnterFullscreen) { // Safari on iPhone
                        document.documentElement.webkitEnterFullscreen();
                    }
                }

            // Tentar entrar no modo tela cheia no carregamento da página
            enterFullScreen();
        });

        // Eventos de mudança de tela cheia
        document.addEventListener('fullscreenchange', () => {
            console.log('Fullscreen mode changed:', document.fullscreenElement);
        });
        document.addEventListener('mozfullscreenchange', () => {
            console.log('Fullscreen mode changed (Mozilla):', document.mozFullScreenElement);
        });
        document.addEventListener('webkitfullscreenchange', () => {
            console.log('Fullscreen mode changed (Webkit):', document.webkitFullscreenElement);
        });
        document.addEventListener('msfullscreenchange', () => {
            console.log('Fullscreen mode changed (IE/Edge):', document.msFullscreenElement);
        });
        document.addEventListener('webkitfullscreenchange', () => {
            console.log('Fullscreen mode changed (Safari):', document.webkitFullscreenElement);
        });
    </script>
-->	
    </body>

</html>
