<?php

// Verifica se há um parâmetro 'status' na URL (geralmente enviado ao fazer uma ação)
if (isset($_GET['status'])) {
    // Se o status for 'sucesso', exibe um alerta de sucesso
    if ($_GET['status'] == 'sucesso') {
        echo "<script>alert('Data de saída atualizada com sucesso!');</script>";
    } 
    // Se o status for 'erro' e houver uma mensagem, exibe um alerta com o erro
    else if ($_GET['status'] == 'erro' && isset($_GET['message'])) {
        // Decodifica a mensagem de erro (caso tenha sido codificada na URL)
        $error_message = urldecode($_GET['message']);
        // Exibe o alerta com a mensagem de erro
        echo "<script>alert('$error_message');</script>";
    }
}

// Definindo as informações de acesso ao banco de dados
$host = 'localhost';  // O banco de dados está na máquina local
$dbname = 'login_system';  // Nome do banco de dados
$user = 'root';  // Usuário do banco de dados
$password = '';  // Senha do banco de dados (nesse caso, vazia)

// Estabelece a conexão com o banco de dados usando as informações fornecidas
$conn = new mysqli($host, $user, $password, $dbname);

// Se a conexão falhar, exibe uma mensagem de erro e encerra o script
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Cria uma consulta SQL para selecionar todos os paraquedas que possuem uma data de saída registrada
$sql = "SELECT id, tipo_pqd, numero_velame, numero_involucro, data_inspecao, data_saida FROM inspecao_inicial WHERE data_saida IS NOT NULL";
// Executa a consulta e armazena o resultado em $result
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  <!-- Define a codificação dos caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Ajusta o layout da página para diferentes dispositivos -->
    <title>Paraquedas Manutenido</title>  <!-- Título da página -->
    <link rel="stylesheet" href="paraquedas_manutenidoo.css">  <!-- Link para o arquivo CSS externo para estilizar a página -->
    <link rel="shortcut icon" type="imagex/png" href="imagens/breve_aux-removebg-preview.png">  <!-- Ícone da página -->
</head>
<body>
    <h1>Paraquedas Manutenido</h1>  <!-- Título principal da página -->
    <p>Aqui você pode ver todos os paraquedas que já passaram por todas as inspeções.</p>  <!-- Descrição abaixo do título -->

    <table>  <!-- Inicia a tabela para exibir os dados -->
        <tr>  <!-- Cria uma linha para os cabeçalhos da tabela -->
            <th>Tipo de PQD</th>  <!-- Cabeçalho da coluna para tipo de paraquedas -->
            <th>Número do Velame</th>  <!-- Cabeçalho da coluna para o número do velame -->
            <th>Número do Invólucro</th>  <!-- Cabeçalho da coluna para o número do invólucro -->
            <th>Data de Inspeção Inicial</th>  <!-- Cabeçalho da coluna para a data da inspeção -->
            <th>Data de Saída</th>  <!-- Cabeçalho da coluna para a data de saída -->
            <th>Visualizar Detalhes</th>  <!-- Cabeçalho da coluna para o botão de detalhes -->
        </tr>

        <?php
        // Verifica se a consulta retornou algum resultado
        if ($result->num_rows > 0) {
            // Para cada linha retornada da consulta, exibe os dados na tabela
            while($row = $result->fetch_assoc()) {
                // Cria uma nova linha na tabela para cada registro
                echo "<tr>";
                // Exibe o tipo de paraquedas
                echo "<td>" . $row['tipo_pqd'] . "</td>";
                // Exibe o número do velame
                echo "<td>" . $row['numero_velame'] . "</td>";
                // Exibe o número do invólucro
                echo "<td>" . $row['numero_involucro'] . "</td>";
                // Exibe a data da inspeção inicial
                echo "<td>" . $row['data_inspecao'] . "</td>";
                // Exibe a data de saída
                echo "<td>" . $row['data_saida'] . "</td>";
                // Cria um formulário para permitir visualizar mais detalhes do paraquedas
                echo "<td>
                        <form action='ver_detalhes.php' method='get'>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <input type='submit' value='Ver Detalhes'>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            // Se não houver paraquedas manutenidos, exibe uma mensagem informando
            echo "<tr><td colspan='6'>Nenhum paraquedas manutenido encontrado.</td></tr>";
        }
        ?>
    </table>

    <!-- Botão para voltar à página inicial -->
    <a href="dashboard.php" class="button">Voltar para tela inicial</a>

</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
