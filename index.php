<?php
    include "bd.php";
    include "decrypt.php";
    session_start();
    if ((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("keep-online",$_COOKIE) AND $_COOKIE['keep-online']) OR (array_key_exists("user",$_SESSION))){
        echo "<script>window.location='home.php';</script>";
    }
    if (isset($_POST["submit"])) {
        $user_plain = mysqli_real_escape_string($enlace,$_POST["user"]);
        $data = $user_plain;
        $user = cifrarMensaje($data, $key);
        $query = sprintf("SELECT * FROM users WHERE username='%s'",$user);
        $user_result = mysqli_query($enlace,$query);
        if ($user_result) {
            $pass_plain = mysqli_real_escape_string($enlace,$_POST["passwd"]);
            $data = $pass_plain;
            $pass = cifrarMensaje($data, $key);
            $query = sprintf("SELECT * FROM users WHERE username='%s' AND password='%s'",$user,$pass);
            $resultado = mysqli_query($enlace,$query);
            $fila = mysqli_fetch_array ($resultado);
            if ($fila['username'] === $user && $fila['password'] === $pass){
                $_SESSION['id'] = "1";
                $_SESSION['user'] = $user;
                if ($_POST['cookie'] == "1"){
                    setcookie("keep-online",$fila['hash'],time()+60*60*24*365);
                }
                echo "<script>window.location='home.php';</script>";
            }
            else {
                $errorcode = 1002;
                mysqli_close($enlace);
            }
        }
        else {
            $errorcode = 1001;
            mysqli_close($enlace);
        }
    }
    include "header_login.php";
?>
<form action="index.php" method="post">
    <div class="limiter">
    		<div class="container-login100" style="background-image: url('images/index_bg-01.jpg');">
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
    
    						<a href="pass_forgot.php" class="txt2 bo1 m-l-5">
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
    					    if ($errorcode === 1001) {
    					        echo "<p style='color: red; text-align: center'>El usuario no es válido</p>";
    					    }
    					    if ($errorcode === 1002){
    					        echo "<p style='color: red; text-align: center'>La contraseña no es válida</p>";
    					    }
    					?>
    					<div class="w-full text-center p-t-55">
    						<span class="txt2">
    							¡Únase a Nosotros!
    						</span>
    
    						<a href="new_acc.php" class="txt2 bo1">
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