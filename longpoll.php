<?php

session_start();
$caminho_relativo = $_SESSION['caminho_relativo'];


header("Content-Type: text/plain");

$lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
$currentmodif = filemtime($caminho_relativo);

while ($currentmodif <= $lastmodif) {
    usleep(10000); // espera 10ms para evitar sobrecarga do servidor
    clearstatcache();
    $currentmodif = filemtime($caminho_relativo);
}

echo $currentmodif;
?>
