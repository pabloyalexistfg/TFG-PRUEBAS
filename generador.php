<?php
    function cifrarMensaje($mensaje, $clave) {
      $mensajeCifrado = '';
      for ($i = 0; $i < strlen($mensaje); $i++) {
        $mensajeCifrado .= ($mensaje[$i] ^ $clave[$i % strlen($clave)]);
      }
      return base64_encode($mensajeCifrado);
    }
    
    // Función para descifrar un mensaje cifrado utilizando XOR y Base64
    function descifrarMensaje($mensajeCifrado, $clave) {
      $mensaje = base64_decode($mensajeCifrado);
      $mensajeDescifrado = '';
      for ($i = 0; $i < strlen($mensaje); $i++) {
        $mensajeDescifrado .= ($mensaje[$i] ^ $clave[$i % strlen($clave)]);
      }
      return $mensajeDescifrado;
    }
    
    // Ejemplo de uso
    $mensaje = "pablo@pablo.com";
    $clave = "lleva-la-tarara-un-vestido-blanco-lleno-de-cascabeles";
    $mensajeCifrado = cifrarMensaje($mensaje, $clave);
    echo "Mensaje cifrado: " . $mensajeCifrado . "<br>";
    $mensajeDescifrado = descifrarMensaje($mensajeCifrado, $clave);
    echo "Mensaje descifrado: " . $mensajeDescifrado;
?>