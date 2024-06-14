<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
</head>
<body style="background-color: #363636;">
    <h1 style="color: white;">Palantír</h1>
    <form method="post">
        <label style="color: white;" for="nome_usuario">Sala:</label>
        <input type="text" id="nome_usuario" name="nome_usuario">
        <button type="submit">Criar/Entrar</button>
    </form>
    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sala = $_POST["nome_usuario"];

                    // Evita ataques de XSS
                    $sala = htmlspecialchars($_POST["nome_usuario"]);
    
                    // Verifica se o nome de usuário é válido
                    if (!preg_match('/^[a-zA-Z0-9_]+$/', $sala)) {
                        echo "<p style='color: red;'>Nome de usuário inválido. Use apenas letras, números e '_'.</p>";
                        exit;
                    }

            mt_srand(crc32($sala)); // define a semente com base no nome do usuário
            $nome_usuario = mt_rand(); // gera um número aleatório de 1 a 100 com base na semente
    
            

            
                    // Evita ataques de path traversal
                    $nome_arquivo = basename($nome_usuario);
                    $arquivo = realpath("$nome_arquivo.txt");
    
        // Verifica se o arquivo já existe
        if (file_exists("$nome_usuario.txt")) {
            $caminho_arquivo = realpath("$nome_usuario.txt");
            $caminho_relativo = str_replace($_SERVER['DOCUMENT_ROOT'], "", $caminho_arquivo);
            session_start();
            $_SESSION['caminho_relativo'] = $caminho_relativo;
            header("Location: chat.php?arquivo=$caminho_relativo");
            exit;
        }

        $arquivo = fopen("$nome_usuario.txt", "w");
        fwrite($arquivo, "\n\n");

        fclose($arquivo);
        $caminho_arquivo = realpath("$nome_usuario.txt");
        $caminho_relativo = str_replace($_SERVER['DOCUMENT_ROOT'], "", $caminho_arquivo);


        session_start();
        $_SESSION['caminho_relativo'] = $caminho_relativo;
        

        echo "<p>O arquivo $caminho_arquivo foi criado com sucesso.</p>";
        echo "<p>O caminho relativo do arquivo é: $caminho_relativo </p>";

        header("Location: chat.php?arquivo=$caminho_relativo");
        exit;
    }
    ?>
</body>
</html>
