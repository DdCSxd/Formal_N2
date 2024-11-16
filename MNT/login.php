<?php

session_start();  // Inicia uma nova sessão ou retoma a sessão existente. Essencial para armazenar dados do usuário durante a navegação.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Verifica se o formulário foi enviado usando o método POST (que é o método padrão para envio de dados de formulários).
    
    $host = 'localhost';  // Define o endereço do servidor de banco de dados (localhost significa que o banco de dados está no mesmo servidor que o site).
    $dbname = 'login_system';  // Define o nome do banco de dados onde os dados de login dos usuários estão armazenados.
    $user = 'root';  // Define o nome de usuário para conectar ao banco de dados.
    $password = '';  // Define a senha para conectar ao banco de dados. Neste caso, o banco de dados local não possui senha configurada.

    $conn = new mysqli($host, $user, $password, $dbname);  // Cria uma conexão com o banco de dados usando os dados fornecidos.

    if ($conn->connect_error) {  // Verifica se houve algum erro ao tentar conectar ao banco de dados.
        die("Conexão falhou: " . $conn->connect_error);  // Se a conexão falhar, exibe uma mensagem de erro e para a execução do script.
    }

    // Recebe os dados do formulário de login, 'username' é o nome de usuário e 'password' é a senha.
    $username = $_POST['username'];  
    $password = $_POST['password'];  

    // Prepara uma consulta SQL para buscar a senha (armazenada de forma segura, como um hash) do usuário no banco de dados.
    $stmt = $conn->prepare("SELECT senha FROM users WHERE login = ?");  
    $stmt->bind_param("s", $username);  // "s" indica que o parâmetro é uma string. O parâmetro do usuário será vinculado à consulta.
    $stmt->execute();  // Executa a consulta SQL.
    $stmt->store_result();  // Armazena o resultado da consulta para ser usado mais tarde.

    if ($stmt->num_rows > 0) {  // Verifica se existe algum usuário com o nome fornecido.
        
        $stmt->bind_result($hash_senha);  // Obtém o valor da senha (em hash) da consulta.
        $stmt->fetch();  // Obtém o resultado da consulta e armazena a senha na variável $hash_senha.

        // Compara a senha fornecida no formulário com a senha armazenada (hash).
        if ($password === $hash_senha) {  
            
            header("Location: /mnt/dashboard.php");  // Se a senha estiver correta, redireciona o usuário para a página do dashboard.
            exit();  // Encerra a execução do script após o redirecionamento.
        } else {
            // Se a senha estiver incorreta, exibe uma mensagem de erro.
            $error = "Login ou senha incorretos.";  
        }
    } else {
        // Se o usuário não for encontrado, exibe uma mensagem de erro.
        $error = "Login ou senha incorretos.";  
    }

    $stmt->close();  // Fecha a consulta preparada para liberar recursos.
    $conn->close();  // Fecha a conexão com o banco de dados.
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  <!-- Define a codificação de caracteres como UTF-8, que suporta caracteres especiais como acentos. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Faz o site ser responsivo em dispositivos móveis. -->
    <link rel="stylesheet" href="logi.css">  <!-- Inclui o arquivo de estilo CSS para o layout da página. -->
    <link rel="shortcut icon" type="imagex/png" href="imagens/breve_aux-removebg-preview.png">  <!-- Define o ícone da aba do navegador. -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">  <!-- Inclui a fonte Roboto do Google Fonts. -->
    <title>Tela de Login</title>  <!-- Define o título da aba do navegador. -->
</head>
<body>

    <header>  <!-- Cabeçalho da página. -->
        <h1>Errar nunca</h1>  <!-- Exibe o título principal na parte superior da página. -->
    </header>

    <main>  <!-- Início do conteúdo principal da página. -->
        
        <div class="login-container">  <!-- Container que envolve o formulário de login. -->
            <h2>Login</h2>  <!-- Título "Login" que aparece no formulário. -->
            
            <!-- Exibe a mensagem de erro se a variável $error não estiver vazia. -->
            <?php if (!empty($error)): ?>  
                <p class="error-message"><?php echo $error; ?></p>  <!-- Exibe a mensagem de erro de login e senha. -->
            <?php endif; ?>
                
            <!-- Formulário de login -->
            <form action="login.php" method="post">  <!-- Define que o formulário envia dados via método POST para a página login.php. -->
                <label for="username">Usuário:</label>  <!-- Rótulo para o campo de nome de usuário. -->
                <input type="text" id="username" name="username" required>  <!-- Campo de texto para o nome de usuário. O atributo 'required' obriga o preenchimento do campo. -->
                <br><br>
                
                <label for="password">Senha:</label>  <!-- Rótulo para o campo de senha. -->
                <input type="password" id="password" name="password" required>  <!-- Campo de senha que esconde os caracteres digitados. -->
                <br><br>
                
                <input class="botao" type="submit" value="Entrar">  <!-- Botão para enviar o formulário. -->
            </form>
        </div>
    </main>
    
    <footer>  <!-- Rodapé da página. -->
        <p>Criação e Desenvolvimento: Deone, Sara, Raphaella e Davi ©2024 - Oficina de Programação</p>  <!-- Informações sobre os criadores do sistema. -->
    </footer>

</body>
</html>
