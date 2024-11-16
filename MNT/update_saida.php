<?php

// Definindo as variáveis de conexão com o banco de dados
$host = 'localhost'; // O servidor onde o banco de dados está hospedado
$dbname = 'login_system'; // O nome do banco de dados
$user = 'root'; // O nome de usuário para conectar ao banco de dados
$password = ''; // A senha do usuário para conectar ao banco de dados

// Criando uma nova conexão com o banco de dados usando as variáveis definidas acima
$conn = new mysqli($host, $user, $password, $dbname);

// Verificando se houve erro na conexão
if ($conn->connect_error) {
    // Se houver erro, exibe a mensagem de erro e interrompe a execução do código
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebendo os dados enviados pelo formulário
$id = $_POST['id']; // O ID da inspeção que será atualizada
$data_saida = $_POST['data_saida']; // A nova data de saída que será atribuída à inspeção

// Criando a consulta SQL para atualizar a data de saída e o status da inspeção
$sql = "UPDATE inspecao_inicial SET data_saida = ?, status = 1 WHERE id = ?";

// Preparando a consulta SQL para execução, evitando injeção de SQL
$stmt = $conn->prepare($sql);

// Vinculando os parâmetros da consulta (data_saida e id) com os valores recebidos do formulário
$stmt->bind_param("si", $data_saida, $id); // 's' para string (data_saida), 'i' para inteiro (id)

// Executando a consulta SQL
if ($stmt->execute()) {
    // Se a execução for bem-sucedida, redireciona para a página inspecao_final.php com uma mensagem de sucesso
    header("Location: inspecao_final.php?status=sucesso");
} else {
    // Se ocorrer um erro na execução, captura a mensagem de erro e redireciona para a página inspecao_final.php com a mensagem de erro
    $error_message = urlencode("Erro ao atualizar a data de saída: " . $stmt->error);
    header("Location: inspecao_final.php?status=erro&message=$error_message");
}

// Fechando a declaração SQL para liberar os recursos
$stmt->close();

// Fechando a conexão com o banco de dados
$conn->close();
?>
