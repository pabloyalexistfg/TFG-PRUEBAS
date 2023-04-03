<?php
    include "bd.php";
    include "decrypt.php";
    session_start();
    if ((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("keep-online",$_COOKIE) AND $_COOKIE['keep-online']) OR (array_key_exists("user",$_SESSION))){
        echo "<script>window.location='home.php';</script>";
    }
    if (isset($_POST["submit"])) {
        $name = mysqli_real_escape_string($enlace,$_POST["name"]);
        $surname = mysqli_real_escape_string($enlace,$_POST["surname"]);
        $tipo_cuenta = 1;
        $user_plain = mysqli_real_escape_string($enlace,$_POST["user"]);
        $data = $user_plain;
        $user = cifrarMensaje($data, $key);
        $query = sprintf("SELECT * FROM users WHERE username='%s'",$user);
        $user_result = mysqli_query($enlace,$query);
        $get_user = mysqli_fetch_assoc($user_result);
        if ($get_user['username'] == $user) {
            $errorcode = 1001;
            mysqli_close($enlace);
        }
        else {
            $pass_plain = mysqli_real_escape_string($enlace,$_POST["passwd"]);
            $data = $pass_plain;
            $pass = cifrarMensaje($data, $key);
            $has_uppercase = preg_match('/[A-Z]/', $pass_plain);
            $has_number = preg_match('/\d/', $pass_plain);
            $is_long_enough = strlen($pass_plain) >= 8;
            if ($has_uppercase && $has_number && $is_long_enough) {
                $mail_plain = mysqli_real_escape_string($enlace,$_POST["mail"]);
                $data = $mail_plain;
                $mail = cifrarMensaje($data, $key);
                $query = sprintf("SELECT * FROM users WHERE email='%s'",$mail);
                $mail_result = mysqli_query($enlace,$query);
                $get_mail = mysqli_fetch_assoc($mail_result);
                if ($get_mail['email'] == $mail) {
                    $errorcode = 1003;
                    mysqli_close($enlace);
                } else {
                    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $mail_plain)) {
                        $errorcode = 1004;
                        mysqli_close($enlace);
                    } else {
                        $hash = md5($user);
                        $descripcion = "";
                        $query = sprintf("INSERT INTO users(username, password, email, nombre, apellidos, descripcion, tipocuenta, hash) VALUES('%s','%s','%s','%s','%s','%s','%s','%s')", $user, $pass, $mail, $name, $surname, $descripcion, $tipo_cuenta, $hash);
                        $resultado = mysqli_query($enlace,$query);
                        if ($resultado){
                            header("Location: welcome.php");
                        } else {
                            $errorcode = 1005;
                        }
                    }
                }
            } else {
                $errorcode = 1002;
                mysqli_close($enlace);
            }
        }
    }
    include "header_new_acc.php";
?>
<form action="new_acc.php" method="post">
    <div class="limiter">
    		<div class="container-login100" style="background-image: url('images/index_bg-01.jpg');">
    			<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
    				<form class="login100-form validate-form flex-sb flex-w">
    					<span class="login100-form-title p-b-53">
    						Cuenta Nueva
    					</span>
    					<div class="p-t-31 p-b-9">
    						<span class="txt1">
    							Correo Electrónico
    						</span>
    					</div>
    					<div class="wrap-input100 validate-input" data-validate = "Mail is required">
    						<input class="input100" type="text" name="mail" >
    						<span class="focus-input100"></span>
    					</div>
    					<div class="p-t-31 p-b-9">
    						<span class="txt1">
    							Nombre
    						</span>
    					</div>
    					<div class="wrap-input100 validate-input" data-validate = "Name is required">
    						<input class="input100" type="text" name="name" >
    						<span class="focus-input100"></span>
    					</div>
    					<div class="p-t-31 p-b-9">
    						<span class="txt1">
    							Apellidos
    						</span>
    					</div>
    					<div class="wrap-input100 validate-input" data-validate = "Surnames is required">
    						<input class="input100" type="text" name="surname" >
    						<span class="focus-input100"></span>
    					</div>
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
    					</div>
    					<div class="wrap-input100 validate-input" data-validate = "Password is required">
    						<input class="input100" type="password" name="passwd" >
    						<span class="focus-input100"></span>
    					</div>
    					
    					<br>
    					<div class="container-login100-form-btn m-t-17">
    						<button class="login100-form-btn" name="submit">
    							Crear Cuenta
    						</button>
    					</div>
    					<?php
    					    if ($errorcode === 1001) {
    					        echo "<p style='color: red; text-align: center'>El usuario ya existe</p>";
    					    }
    					    if ($errorcode === 1002){
    					        echo "<p style='color: red; text-align: center'>La contraseña debe ser más compleja</p>";
    					    }
    					    if ($errorcode === 1003){
    					        echo "<p style='color: red; text-align: center'>El correo ya está registrado</p>";
    					    }
    					    if ($errorcode === 1004){
    					        echo "<p style='color: red; text-align: center'>El correo no es válido</p>";
    					    }
    					    if ($errorcode === 1005){
    					        echo "<p style='color: red; text-align: center'>Algo ha ido mal :(</p>";
    					    }
    					?>
    				</form>
    			</div>
    		</div>
    	</div>
    	<div id="dropDownSelect1"></div>
</form>
<?php
    include "footer_login.php";
?>