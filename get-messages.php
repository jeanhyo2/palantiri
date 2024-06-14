<?php

session_start();
$caminho_relativo = $_SESSION['caminho_relativo'];



$file = $caminho_relativo;
echo file_get_contents($file);
?>
