<?php
    include "bd.php";
    session_start();
    if ((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("keep-online",$_COOKIE) AND $_COOKIE['keep-online'])){
        echo "<script>window.location='home.php';</script>";
    }
    if (isset($_POST["submit"])) {
        //HABRIA QUE CONTROLAR LA ENTRADA
        $usu2 = mysqli_real_escape_string($enlace,$_POST["user"]);
        $pass2 = mysqli_real_escape_string($enlace,$_POST["passwd"]);
        $usu = md5($usu2);
        $pass = md5($pass2);
        $query = sprintf("SELECT * FROM users WHERE username='%s' AND password='%s'",$usu,$pass);
        $resultado = mysqli_query($enlace,$query);
        if ($resultado) {
            $fila = mysqli_fetch_array ($resultado);
            if (mysqli_num_rows($resultado)>0) {
                $_SESSION['id'] = rand(0,500);
                $_SESSION['user']= $usu;
                if ($_POST['cookie']==='1'){
                    setcookie("keep-online",$fila['hash'],time()+60*60*24*365);
                }
                echo "<script>window.location='home.php';</script>";
            }
            else {
                $errorcode = 405;
                mysqli_close($enlace);
            }
        }
    }
    include "header_login.php";
?>
<form action="index.php" method="post">
    <div class="limiter">
    		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
    			<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
    				<form class="login100-form validate-form flex-sb flex-w">
    					<span class="login100-form-title p-b-53">
    						Inicie Sesión
    					</span>
    					<div class="p-t-31 p-b-9">
    						<span class="txt1">
    							Usuario
    						</span>
    					</div>
    					<div class="wrap-input100 validate-input" data-validate = "Username is required">
    						<input class="input100" type="text" name="user" >
    						<span class="focus-input100"></span>
    					</div>
    					
    					<div class="p-t-13 p-b-9">
    						<span class="txt1">
    							Contraseña
    						</span>
    
    						<a href="#" class="txt2 bo1 m-l-5">
    							He olvidado mi contraseña
    						</a>
    					</div>
    					
    					<div class="wrap-input100 validate-input" data-validate = "Password is required">
    						<input class="input100" type="password" name="passwd" >
    						<span class="focus-input100"></span>
    					</div>
    
    					<div class="container-login100-form-btn m-t-17">
    						<button class="login100-form-btn" name="submit">
    							Entrar
    						</button>
    					</div>
    					<br>
    					<p style="text-align: center; font-size: 16px;">Recordar Usuario <input type="checkbox" name="cookie" value="1"></p>
    					<?php
    					    if ($errorcode==405) {
    					        echo "<p style='color: red; text-align: center'>No es un usuario registrado</p>";
    					    }
    					?>
    					<div class="w-full text-center p-t-55">
    						<span class="txt2">
    							¡Únase a Nosotros!
    						</span>
    
    						<a href="sign-up.php" class="txt2 bo1">
    							Crear Cuenta
    						</a>
    					</div>
    				</form>
    			</div>
    		</div>
    	</div>
    	
    
    	<div id="dropDownSelect1"></div>
</form>
<?php
    include "footer_login.php";
?>