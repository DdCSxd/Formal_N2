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
    // Exibe uma mensagem de erro e encerra o programa se a conexão falhar.
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado e contém um campo chamado 'id'.
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Recebe o valor do campo 'id' enviado pelo formulário.

    // Define a consulta SQL para excluir um registro com base no ID fornecido.
    $sql = "DELETE FROM inspecao_inicial WHERE id = ?";

    // Prepara a consulta para evitar falhas ou ataques (como SQL Injection).
    $stmt = $conn->prepare($sql);

    // Substitui o '?' no comando SQL pelo valor do ID fornecido.
    $stmt->bind_param("i", $id);

    // Executa a consulta no banco de dados.
    if ($stmt->execute()) {
        // Exibe uma mensagem de sucesso se a exclusão for concluída.
        echo "Paraquedas excluído com sucesso.";
    } else {
        // Exibe uma mensagem de erro se a exclusão falhar.
        echo "Erro ao excluir o paraquedas: " . $conn->error;
    }

    // Fecha a declaração preparada para liberar recursos.
    $stmt->close();
} else {
    // Exibe uma mensagem de erro se o ID não foi fornecido no formulário.
    echo "ID não fornecido para exclusão.";
}

// Fecha a conexão com o banco de dados.
$conn->close();

// Redireciona o usuário para a página de inspeção final.
header("Location: inspecao_final.php");
exit(); // Garante que o script termine após o redirecionamento.
?>
