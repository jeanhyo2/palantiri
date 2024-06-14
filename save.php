<?php

session_start();
$caminho_relativo = $_SESSION['caminho_relativo'];



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['message'])) {
        $message = $_POST['message'];
        $fp = fopen($caminho_relativo, 'a');
        fwrite($fp, $message . PHP_EOL);
        fclose($fp);
        exit();
    }
}
?>
