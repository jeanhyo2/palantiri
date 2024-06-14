<!DOCTYPE html>
<html>
<head>
    <?php
session_start();
$caminho_relativo = isset($_SESSION['caminho_relativo']) ? $_SESSION['caminho_relativo'] : '';

?>

    <title>Palantír</title>
<style>
    body {
      background-color: #363636;
    }

    h1 {
      color: white;
    }
  </style>
</head>
<body bgcolor="#C0C0C0">
    <h1 color:red>Palantír</h1>
    <textarea id="chat" rows="10" cols="50">
    <?php echo file_get_contents($caminho_relativo); ?>
</textarea>
    <form id="message-form">
        <input type="text" name="message" placeholder="Usuário" size="5">
        <input type="text" name="word" placeholder="Digite sua mensagem aqui...">
        <button type="submit">Enviar</button>
        <button type="button" onclick="clearChat()">Limpar Chat</button>
    </form>

    <script>
        // função para atualizar o conteúdo da página
        function updateChat() {
            
            var chat = document.getElementById("chat");
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "update.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var content = xhr.responseText;
                    if (content !== chat.value) {
                        chat.value = content;
                        chat.scrollTop = chat.scrollHeight;

                    }
                }
            };
            xhr.send();
            chat.scrollTop = chat.scrollHeight;

        }

         // função para limpar o conteúdo do arquivo chat.txt
         function clearChat() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "clear.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    updateChat();
                }
            };
            xhr.send();
        }

        // atualiza o chat a cada 2 segundos
        setInterval(updateChat, 2000);

// envia a mensagem para o servidor
document.getElementById("message-form").addEventListener("submit", function(event) {
    event.preventDefault();
    var message = this.elements["message"].value;
    var word = this.elements["word"].value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            this.elements["message"].value = "";
            this.elements["word"].value = "";
            updateChat(); // adiciona essa linha para atualizar o chat após enviar a mensagem
        }
    };
    xhr.send("message=" + encodeURIComponent(message + " - " + word));
    this.elements["word"].value = ""; // adiciona esta linha para limpar o campo de texto "word"
});

    </script>
</body>
</html>
