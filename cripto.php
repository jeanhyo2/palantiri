<?php

function criptografar($texto, $seed) {
  $chave = hash('sha256', $seed, true);
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  $ciphertext = openssl_encrypt($texto, 'aes-256-cbc', $chave, OPENSSL_RAW_DATA, $iv);
  return base64_encode($iv . $ciphertext);
}

function descriptografar($textoCriptografado, $seed) {
  $ciphertext = base64_decode($textoCriptografado);
  $chave = hash('sha256', $seed, true);
  $ivLength = openssl_cipher_iv_length('aes-256-cbc');
  $iv = substr($ciphertext, 0, $ivLength);
  $ciphertext = substr($ciphertext, $ivLength);
  $texto = openssl_decrypt($ciphertext, 'aes-256-cbc', $chave, OPENSSL_RAW_DATA, $iv);
  return $texto;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $seed = $_POST["seed"];
  $texto = $_POST["texto"];

  // criptografa o texto com a seed fornecida
  $textoCriptografado = criptografar($texto, $seed);
  echo "<p>Texto criptografado: $textoCriptografado</p>";

  if (!empty($_POST["textoCriptografado"]) && !empty($_POST["seedDescriptografar"])) {
    // descriptografa o texto criptografado com a seed fornecida
    $textoDescriptografado = descriptografar($_POST["textoCriptografado"], $_POST["seedDescriptografar"]);
    echo "<p>Texto descriptografado: $textoDescriptografado</p>";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Criptografia</title>
</head>
<body>
  <h1>Criptografia de texto</h1>
  <form method="post">
    <label for="seed">Seed:</label><br>
    <input type="text" id="seed" name="seed" autocomplete="off"><br><br>
    <label for="texto">Texto:</label><br>
    <input type="text" id="texto" name="texto" autocomplete="off"><br><br>
    <button type="submit">Criptografar</button><br><br>
    <label for="textoCriptografado">Texto criptografado:</label><br>
    <input type="text" id="textoCriptografado" name="textoCriptografado" autocomplete="off"><br><br>
    <label for="seedDescriptografar">Seed para descriptografar:</label><br>
    <input type="text" id="seedDescriptografar" name="seedDescriptografar" autocomplete="off"><br><br>
    <button type="submit">Descriptografar</button>
  </form>
</body>
</html>
