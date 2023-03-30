<?php
    session_start();
    if ((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("keep-online",$_COOKIE) AND $_COOKIE['keep-online']) OR (array_key_exists("user",$_SESSION))){
        if (array_key_exists("keep-online",$_COOKIE)){
            $hash = $_COOKIE['keep-online'];
            $active_user_select = "SELECT username FROM users WHERE hash='{$hash}'";
            $active_user_query = mysqli_query($enlace, $active_user_select);
            $active_user_result = mysqli_fetch_assoc($active_user_query);
            $active_user = $active_user_result['username'];
            $_SESSION['user'] = $active_user;
            $online = 1;
        }
        else {
            $active_user = $_SESSION['user'];
            $online = 1;
        }
    }
    else{
        header("Location: index.php");
    }
?>
