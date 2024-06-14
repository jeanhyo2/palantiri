<?php

session_start();
$caminho_relativo = $_SESSION['caminho_relativo'];



header("Content-Type: text/plain");
echo file_get_contents($caminho_relativo);
?>
