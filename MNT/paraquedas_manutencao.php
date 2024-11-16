<?php

$host = 'localhost';
$dbname = 'login_system';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


$sql = "SELECT id, tipo_pqd, numero_velame, numero_involucro, data_inspecao FROM inspecao_inicial";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paraquedas em Manutenção</title>
    <link rel="shortcut icon" type="imagex/png" href="imagens/breve_aux-removebg-preview.png">
    <link rel="stylesheet" href="paraquedas_manutenca.css"> <!-- Link para o CSS externo -->
</head>
<body>
    <h1>Paraquedas em Manutenção</h1>
    <p>Abaixo estão listados todos os paraquedas que passaram pela inspeção inicial:</p>

    <table>
        <tr>
            <th>Tipo de PQD</th>
            <th>Número do Velame</th>
            <th>Número do Invólucro</th>
            <th>Data de Inspeção</th>
            <th>Ação</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['tipo_pqd'] . "</td>";
                echo "<td>" . $row['numero_velame'] . "</td>";
                echo "<td>" . $row['numero_involucro'] . "</td>";
                echo "<td>" . $row['data_inspecao'] . "</td>";
                echo "<td>
                        <a href='detalhes_paraquedas.php?id=" . $row['id'] . "' class='button'>Ver Detalhes</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum paraquedas encontrado.</td></tr>";
        }
        ?>

    </table>

    <a href="dashboard.php" class="button">Voltar para tela inicial</a>

</body>
</html>

<?php
$conn->close();
?>
