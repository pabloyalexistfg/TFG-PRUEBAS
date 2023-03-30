<?php
    include "bd.php";
    include "session_check.php";
    if ($online === 1){
        include "decrypt.php";
        $encrypted_data = $active_user;
        $user = descifrarMensaje($encrypted_data, $key);
        echo "<p>Hola {'$user'}</p>";
    }
    else {
        header("Location: index.php");
    }
?>
