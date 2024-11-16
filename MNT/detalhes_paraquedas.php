<?php

// Define as informações necessárias para conectar ao banco de dados.
$host = 'localhost'; // Endereço do servidor do banco de dados.
$dbname = 'login_system'; // Nome do banco de dados.
$user = 'root'; // Nome de usuário para o banco de dados.
$password = ''; // Senha do usuário.

$conn = new mysqli($host, $user, $password, $dbname); // Conecta ao banco usando a classe mysqli.

// Verifica se houve erro na conexão com o banco.
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error); // Exibe uma mensagem e interrompe a execução.
}

// Verifica se o ID foi enviado via GET (URL).
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Armazena o ID enviado.

    // Monta a consulta SQL para buscar os detalhes do paraquedas com o ID fornecido.
    $sql = "SELECT * FROM inspecao_inicial WHERE id = $id";

    $result = $conn->query($sql); // Executa a consulta no banco de dados.

    if ($result->num_rows > 0) {
        $paraquedas = $result->fetch_assoc(); // Armazena os dados retornados em um array associativo.
    } else {
        die("Paraquedas não encontrado."); // Exibe erro se nenhum registro for encontrado.
    }
} else {
    die("ID do paraquedas não especificado."); // Exibe erro se o ID não foi fornecido.
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Paraquedas</title>
    <!-- Favicon para o navegador -->
    <link rel="shortcut icon" type="imagex/png" href="imagens/breve_aux-removebg-preview.png">
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="detalhes_paraqueda.css">
</head>
<body>
    <h1>Detalhes do Paraquedas</h1>

    <!-- Tabela para exibir os detalhes do paraquedas -->
    <table>
        <tr>
            <th>Tipo de PQD</th>
            <td><?php echo $paraquedas['tipo_pqd']; ?></td> <!-- Exibe o tipo do paraquedas -->
        </tr>
        <tr>
            <th>Número do Velame</th>
            <td><?php echo $paraquedas['numero_velame']; ?></td> <!-- Exibe o número do velame -->
        </tr>
        <tr>
            <th>Número do Invólucro</th>
            <td><?php echo $paraquedas['numero_involucro']; ?></td> <!-- Exibe o número do invólucro -->
        </tr>
        <tr>
            <th>Data de Fabricação</th>
            <td><?php echo $paraquedas['data_fabricacao']; ?></td> <!-- Exibe a data de fabricação -->
        </tr>
        <tr>
            <th>Inspecionado por</th>
            <td><?php echo $paraquedas['inspecionado_por']; ?></td> <!-- Exibe o inspetor responsável -->
        </tr>
        <tr>
            <th>Data de Inspeção</th>
            <td><?php echo $paraquedas['data_inspecao']; ?></td> <!-- Exibe a data da inspeção -->
        </tr>
        <tr>
            <th>Observações</th>
            <td><?php echo $paraquedas['observacoes']; ?></td> <!-- Exibe observações gerais -->
        </tr>

        <!-- Exibição de detalhes do remendo, se aplicável -->
        <tr>
            <th>Remendo</th>
            <td><?php echo ($paraquedas['remendo'] === 'sim') ? 'Sim' : 'Não'; ?></td>
        </tr>
        <?php if ($paraquedas['remendo'] === 'sim') : ?>
        <tr>
            <th>Painel do Remendo</th>
            <td><?php echo $paraquedas['remendo_painel']; ?></td>
        </tr>
        <tr>
            <th>Seção do Remendo</th>
            <td><?php echo $paraquedas['remendo_secao']; ?></td>
        </tr>
        <?php endif; ?>

        <!-- Exibição de detalhes da substituição, se aplicável -->
        <tr>
            <th>Substituição</th>
            <td><?php echo ($paraquedas['substituicao'] === 'sim') ? 'Sim' : 'Não'; ?></td>
        </tr>
        <?php if ($paraquedas['substituicao'] === 'sim') : ?>
        <tr>
            <th>Painel da Substituição</th>
            <td><?php echo $paraquedas['substituicao_painel']; ?></td>
        </tr>
        <tr>
            <th>Seção da Substituição</th>
            <td><?php echo $paraquedas['substituicao_secao']; ?></td>
        </tr>
        <?php endif; ?>

        <!-- Exibição de detalhes da recostura, se aplicável -->
        <tr>
            <th>Recostura</th>
            <td><?php echo ($paraquedas['recostura'] === 'sim') ? 'Sim' : 'Não'; ?></td>
        </tr>
        <?php if ($paraquedas['recostura'] === 'sim') : ?>
        <tr>
            <th>Painel da Recostura</th>
            <td><?php echo $paraquedas['recostura_painel']; ?></td>
        </tr>
        <tr>
            <th>Seção da Recostura</th>
            <td><?php echo $paraquedas['recostura_secao']; ?></td>
        </tr>
        <?php endif; ?>

        <!-- Exibição de detalhes da troca de linha, se aplicável -->
        <tr>
            <th>Troca de Linha</th>
            <td><?php echo ($paraquedas['troca_linha'] === 'sim') ? 'Sim' : 'Não'; ?></td>
        </tr>
        <?php if ($paraquedas['troca_linha'] === 'sim') : ?>
        <tr>
            <th>Número da Linha Trocada</th>
            <td><?php echo $paraquedas['troca_linha_numero']; ?></td>
        </tr>
        <?php endif; ?>
    </table>

    <!-- Link para voltar à lista de manutenção -->
    <a href="paraquedas_manutencao.php" class="button">Voltar para a Lista de Manutenção</a>

</body>
</html>

<?php
$conn->close(); // Fecha a conexão com o banco de dados.
?>
