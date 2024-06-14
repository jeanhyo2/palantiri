<?php


session_start();
$caminho_relativo = $_SESSION['caminho_relativo'];



$file = $caminho_relativo;
file_put_contents($file, "");
?>
