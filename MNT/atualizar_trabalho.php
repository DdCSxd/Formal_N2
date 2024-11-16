<?php

// Define as informações necessárias para conectar ao banco de dados.
$host = 'localhost'; // Endereço do servidor do banco de dados.
$dbname = 'login_system'; // Nome do banco de dados que será usado.
$user = 'root'; // Nome de usuário para acessar o banco de dados.
$password = ''; // Senha do usuário para o banco de dados.

// Estabelece uma conexão com o banco de dados usando a classe mysqli.
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica se houve um erro na conexão com o banco de dados.
if ($conn->connect_error) {
    // Exibe uma mensagem de erro e encerra o programa, caso a conexão falhe.
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado com um campo chamado 'id'.
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Recebe o valor do campo 'id' enviado pelo formulário.

    // Verifica se os campos de trabalho (remendo, substituição, etc.) foram marcados.
    // Se marcados, atribui 1; caso contrário, atribui 0.
    $remendo = isset($_POST['remendo']) ? 1 : 0;
    $substituicao = isset($_POST['substituicao']) ? 1 : 0;
    $recostura = isset($_POST['recostura']) ? 1 : 0;
    $troca_linha = isset($_POST['troca_linha']) ? 1 : 0;

    // Define a consulta SQL para atualizar os valores no banco de dados.
    $sql = "UPDATE inspecao_inicial SET remendo = ?, substituicao = ?, recostura = ?, troca_linha = ? WHERE id = ?";

    // Prepara a consulta para evitar falhas ou ataques (como SQL Injection).
    $stmt = $conn->prepare($sql);

    // Substitui os parâmetros '?' na consulta com os valores fornecidos.
    $stmt->bind_param("iiiis", $remendo, $substituicao, $recostura, $troca_linha, $id);

    // Executa a consulta no banco de dados.
    if ($stmt->execute()) {
        // Exibe uma mensagem de sucesso se a atualização for concluída.
        echo "Trabalho realizado atualizado com sucesso!";
    } else {
        // Exibe uma mensagem de erro se houver um problema ao executar a consulta.
        echo "Erro ao atualizar o trabalho realizado: " . $stmt->error;
    }

    // Fecha a declaração preparada para liberar recursos.
    $stmt->close();
}

// Fecha a conexão com o banco de dados.
$conn->close();

// Redireciona o usuário para a página de detalhes com o ID apropriado.
header("Location: detalhes.php?id=$id");
exit(); // Garante que o script termine após o redirecionamento.
?>
