<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres para UTF-8, que suporta caracteres especiais em português -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define a responsividade da página para dispositivos móveis -->
    <title>Detalhes do Paraquedas</title> <!-- Título da página que aparecerá na aba do navegador -->
    <link rel="stylesheet" href="ver_detalhe.css"> <!-- Referência ao arquivo CSS que define o estilo da página -->
</head>
<body>
    <div class="container"> <!-- Contêiner principal da página -->
        <h1>Detalhes do Paraquedas</h1> <!-- Cabeçalho principal da página -->
        <div class="details"> <!-- Div que contém os detalhes do paraquedas -->
            <?php
            // Definindo os parâmetros de conexão com o banco de dados
            $host = 'localhost'; // O servidor onde o banco de dados está hospedado
            $dbname = 'login_system'; // O nome do banco de dados
            $user = 'root'; // O nome de usuário do banco de dados
            $password = ''; // A senha do usuário do banco de dados

            // Estabelecendo a conexão com o banco de dados
            $conn = new mysqli($host, $user, $password, $dbname);

            // Verificando se houve erro na conexão
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error); // Se houver erro, exibe uma mensagem e encerra o script
            }

            // Verificando se o ID foi passado pela URL
            if (isset($_GET['id'])) {
                $id = $_GET['id']; // Armazenando o ID do paraquedas passado na URL
                
                // Consulta SQL para buscar os detalhes do paraquedas pelo ID
                $sql = "SELECT * FROM inspecao_inicial WHERE id = $id";
                $result = $conn->query($sql); // Executando a consulta no banco de dados

                // Verificando se algum resultado foi encontrado
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc(); // Obtendo os dados da linha encontrada

                    // Exibindo os detalhes do paraquedas com base nos dados retornados
                    echo "<p><strong>Tipo de PQD:</strong> " . $row['tipo_pqd'] . "</p>"; // Exibindo o tipo de paraquedas
                    echo "<p><strong>Número do Velame:</strong> " . $row['numero_velame'] . "</p>"; // Exibindo o número do velame
                    echo "<p><strong>Número do Invólucro:</strong> " . $row['numero_involucro'] . "</p>"; // Exibindo o número do invólucro
                    echo "<p><strong>Data de Fabricação:</strong> " . $row['data_fabricacao'] . "</p>"; // Exibindo a data de fabricação
                    echo "<p><strong>Inspecionado por:</strong> " . $row['inspecionado_por'] . "</p>"; // Exibindo o nome do inspetor
                    echo "<p><strong>Data de Inspeção:</strong> " . $row['data_inspecao'] . "</p>"; // Exibindo a data da inspeção
                    echo "<p><strong>Observações:</strong> " . $row['observacoes'] . "</p>"; // Exibindo as observações feitas durante a inspeção

                    // Exibindo detalhes sobre o remendo
                    echo "<h2>Remendo</h2>";
                    echo "<p>" . ($row['remendo'] === 'sim' ? "Sim" : "Não") . "</p>"; // Verifica se foi feito remendo e exibe "Sim" ou "Não"
                    if ($row['remendo'] === 'sim') { // Se foi feito remendo, exibe mais detalhes
                        echo "<p><strong>Painel:</strong> " . $row['remendo_painel'] . "</p>"; // Exibindo o painel onde foi feito o remendo
                        echo "<p><strong>Seção:</strong> " . $row['remendo_secao'] . "</p>"; // Exibindo a seção onde foi feito o remendo
                    }

                    // Exibindo detalhes sobre a substituição
                    echo "<h2>Substituição</h2>";
                    echo "<p>" . ($row['substituicao'] === 'sim' ? "Sim" : "Não") . "</p>"; // Verifica se houve substituição e exibe "Sim" ou "Não"
                    if ($row['substituicao'] === 'sim') { // Se houve substituição, exibe mais detalhes
                        echo "<p><strong>Painel:</strong> " . $row['substituicao_painel'] . "</p>"; // Exibindo o painel da substituição
                        echo "<p><strong>Seção:</strong> " . $row['substituicao_secao'] . "</p>"; // Exibindo a seção da substituição
                    }

                    // Exibindo detalhes sobre a recostura
                    echo "<h2>Recostura</h2>";
                    echo "<p>" . ($row['recostura'] === 'sim' ? "Sim" : "Não") . "</p>"; // Verifica se houve recostura e exibe "Sim" ou "Não"
                    if ($row['recostura'] === 'sim') { // Se houve recostura, exibe mais detalhes
                        echo "<p><strong>Painel:</strong> " . $row['recostura_painel'] . "</p>"; // Exibindo o painel da recostura
                        echo "<p><strong>Seção:</strong> " . $row['recostura_secao'] . "</p>"; // Exibindo a seção da recostura
                    }

                    // Exibindo detalhes sobre a troca de linha
                    echo "<h2>Troca de Linha</h2>";
                    echo "<p>" . ($row['troca_linha'] === 'sim' ? "Sim" : "Não") . "</p>"; // Verifica se houve troca de linha e exibe "Sim" ou "Não"
                    if ($row['troca_linha'] === 'sim') { // Se houve troca de linha, exibe mais detalhes
                        echo "<p><strong>Número da Linha Trocada:</strong> " . $row['troca_linha_numero'] . "</p>"; // Exibindo o número da linha trocada
                    }

                } else {
                    echo "<p>Nenhum detalhe encontrado para esse paraquedas.</p>"; // Exibe mensagem caso não encontre resultados no banco de dados
                }
            } else {
                echo "<p>ID não fornecido.</p>"; // Exibe mensagem caso o ID não tenha sido fornecido na URL
            }

            // Fechando a conexão com o banco de dados
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
