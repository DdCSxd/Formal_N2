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

// Verifica se o método de requisição é POST, ou seja, se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtém o valor do campo 'tipo_pqd' e verifica se é um array (quando múltiplos valores são selecionados)
    // Se for um array, transforma em uma string separada por vírgulas
    $tipo_pqd = is_array($_POST['tipo_pqd']) ? implode(', ', $_POST['tipo_pqd']) : $_POST['tipo_pqd'];
    
    // Coleta os valores dos outros campos do formulário
    $data_fabricacao = $_POST['data_fabricacao'];
    $numero_velame = $_POST['numero_velame'];
    $numero_involucro = $_POST['numero_involucro'];
    $inspecionado_por = $_POST['inspecionado_por'];
    $data_inspecao = $_POST['data_inspecao'];
    $observacoes = $_POST['observacoes'];

    // Verifica se os campos de trabalho (remendo, substituição, etc.) foram preenchidos
    // Se não, os valores são configurados como null (vazio)
    $remendo = isset($_POST['remendo']) ? $_POST['remendo'] : null;
    $remendo_painel = isset($_POST['remendo_painel']) ? $_POST['remendo_painel'] : null;
    $remendo_secao = isset($_POST['remendo_secao']) ? $_POST['remendo_secao'] : null;
    
    $substituicao = isset($_POST['substituicao']) ? $_POST['substituicao'] : null;
    $substituicao_painel = isset($_POST['substituicao_painel']) ? $_POST['substituicao_painel'] : null;
    $substituicao_secao = isset($_POST['substituicao_secao']) ? $_POST['substituicao_secao'] : null;

    $recostura = isset($_POST['recostura']) ? $_POST['recostura'] : null;
    $recostura_painel = isset($_POST['recostura_painel']) ? $_POST['recostura_painel'] : null;
    $recostura_secao = isset($_POST['recostura_secao']) ? $_POST['recostura_secao'] : null;
    
    $troca_linha = isset($_POST['troca_linha']) ? $_POST['troca_linha'] : null;
    $troca_linha_numero = isset($_POST['troca_linha_numero']) ? $_POST['troca_linha_numero'] : null;

    // Verifica se algum campo obrigatório está vazio. Se estiver, redireciona de volta para a página com um erro
    if (empty($tipo_pqd) || empty($data_fabricacao) || empty($numero_velame) || empty($numero_involucro) || empty($inspecionado_por) || empty($data_inspecao)) {
        header("Location: inspecao_inicial.php?status=erro&message=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
        exit(); // Interrompe a execução do código
    }

    // Cria a consulta SQL para inserir os dados no banco de dados
    $sql = "INSERT INTO inspecao_inicial (tipo_pqd, data_fabricacao, numero_velame, numero_involucro, inspecionado_por, data_inspecao, observacoes, remendo, remendo_painel, remendo_secao, substituicao, substituicao_painel, substituicao_secao, recostura, recostura_painel, recostura_secao, troca_linha, troca_linha_numero) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepara a consulta SQL para execução, usando a conexão com o banco de dados
    $stmt = $conn->prepare($sql);
    // Verifica se houve erro ao preparar a consulta
    if ($stmt === false) {
        die("Erro na preparação da consulta SQL: " . $conn->error);
    }

    // Vincula os parâmetros da consulta SQL aos valores coletados do formulário
    $stmt->bind_param("ssssssssssssssssss", $tipo_pqd, $data_fabricacao, $numero_velame, $numero_involucro, $inspecionado_por, $data_inspecao, $observacoes, $remendo, $remendo_painel, $remendo_secao, $substituicao, $substituicao_painel, $substituicao_secao, $recostura, $recostura_painel, $recostura_secao, $troca_linha, $troca_linha_numero);

    // Executa a consulta SQL
    if ($stmt->execute()) {
        // Se a execução for bem-sucedida, redireciona para a página de inspeção inicial com uma mensagem de sucesso
        header("Location: inspecao_inicial.php?status=sucesso");
    } else {
        // Se ocorrer um erro na execução, captura a mensagem de erro e redireciona com a mensagem de erro
        $error_message = urlencode("Erro ao realizar o cadastro: " . $stmt->error);
        header("Location: inspecao_inicial.php?status=erro&message=$error_message");
    }

    // Fecha a declaração SQL
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
