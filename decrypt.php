<?php
    $key = "lleva-la-tarara-un-vestido-blanco-lleno-de-cascabeles";
    function cifrarMensaje($data, $key) {
      $encrypted_data = '';
      for ($i = 0; $i < strlen($data); $i++) {
        $encrypted_data .= ($data[$i] ^ $key[$i % strlen($key)]);
      }
      return base64_encode($encrypted_data);
    }
    function descifrarMensaje($encrypted_data, $key) {
      $data = base64_decode($encrypted_data);
      $decrypt_data = '';
      for ($i = 0; $i < strlen($data); $i++) {
        $decrypt_data .= ($data[$i] ^ $key[$i % strlen($key)]);
      }
      return $decrypt_data;
    }
?>