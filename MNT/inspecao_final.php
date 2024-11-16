<?php

// Definindo os parâmetros de conexão com o banco de dados
$host = 'localhost'; // O endereço do servidor do banco de dados
$dbname = 'login_system'; // O nome do banco de dados
$user = 'root'; // O usuário do banco de dados
$password = ''; // A senha do usuário

// Criando uma nova conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificando se a conexão com o banco de dados foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error); // Exibe mensagem de erro se falhar
}

// Consulta SQL para pegar os paraquedas com status igual a 0 (em manutenção)
$sql = "SELECT id, tipo_pqd, numero_velame, numero_involucro, data_inspecao, data_saida FROM inspecao_inicial WHERE status = 0";
$result = $conn->query($sql); // Executa a consulta

// Verifica se houve erro na consulta SQL
if ($result === false) {
    die("Erro na consulta SQL: " . $conn->error); // Exibe mensagem de erro se falhar
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspeção Final</title>
    <link rel="stylesheet" href="inspecao_fina.css"> <!-- Link para o CSS externo -->
    <link rel="shortcut icon" type="imagex/png" href="imagens/breve_aux-removebg-preview.png">
</head>
<body>
    <h1>Inspeção Final</h1> <!-- Título da página -->
    <p>Selecione o paraquedas para alterar a data de saída ou excluí-lo.</p> <!-- Descrição da página -->

    <table> <!-- Começa a tabela que vai mostrar os dados -->
        <tr> <!-- Cabeçalhos da tabela -->
            <th>Tipo de PQD</th>
            <th>Número do Velame</th>
            <th>Número do Invólucro</th>
            <th>Data de Inspeção Inicial</th>
            <th>Data de Saída</th>
            <th>Alterar Data de Saída</th>
            <th>Excluir</th>
        </tr>

        <?php
        // Verifica se a consulta retornou resultados
        if ($result->num_rows > 0) {
            // Loop para exibir os dados de cada paraquedas encontrado
            while($row = $result->fetch_assoc()) {
                echo "<tr>"; // Início de uma nova linha na tabela
                echo "<td>" . $row['tipo_pqd'] . "</td>"; // Exibe o tipo do paraquedas
                echo "<td>" . $row['numero_velame'] . "</td>"; // Exibe o número do velame
                echo "<td>" . $row['numero_involucro'] . "</td>"; // Exibe o número do invólucro
                echo "<td>" . $row['data_inspecao'] . "</td>"; // Exibe a data de inspeção
                echo "<td>" . ($row['data_saida'] ? $row['data_saida'] : "Não definida") . "</td>"; // Exibe a data de saída ou "Não definida" caso não exista
                echo "<td>
                        <form action='update_saida.php' method='post'> <!-- Formulário para atualizar a data de saída -->
                            <input type='hidden' name='id' value='" . $row['id'] . "'> <!-- Passa o ID do paraquedas -->
                            <input type='date' name='data_saida' required> <!-- Campo para inserir a nova data de saída -->
                            <input type='submit' value='Atualizar'> <!-- Botão para atualizar -->
                        </form>
                      </td>";
                echo "<td>
                        <form action='delete.php' method='post' onsubmit=\"return confirm('Tem certeza que deseja excluir este paraquedas?');\"> <!-- Formulário para excluir o paraquedas -->
                            <input type='hidden' name='id' value='" . $row['id'] . "'> <!-- Passa o ID do paraquedas -->
                            <input type='submit' value='Excluir' class='delete-button'> <!-- Botão para excluir -->
                        </form>
                      </td>";
                echo "</tr>"; // Fim da linha da tabela
            }
        } else {
            // Caso nenhum paraquedas seja encontrado
            echo "<tr><td colspan='7'>Nenhum paraquedas encontrado.</td></tr>";
        }
        ?>
    </table>

    <a href="dashboard.php" class="button">Voltar para tela inicial</a> <!-- Link para voltar à tela inicial -->

</body>
</html>

<?php
$conn->close(); // Fecha a conexão com o banco de dados
?>
