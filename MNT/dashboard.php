<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Declara que o documento é em HTML5 -->
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres como UTF-8 (suporte para caracteres especiais) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura a página para ser responsiva em dispositivos móveis -->
    <title>Dashboard Dinâmico</title> <!-- Define o título da página exibido no navegador -->
    <link rel="stylesheet" href="dashboar.css"> <!-- Vincula o arquivo CSS externo para estilos -->
    <link rel="shortcut icon" type="imagex/png" href="imagens/breve_aux-removebg-preview.png"> <!-- Adiciona um ícone personalizado à aba do navegador -->
</head>
<body>
    <!-- Início do corpo da página -->

    <!-- Container principal para o conteúdo textual -->
    <div class="content">
        <h1>Manutenção</h1> <!-- Título principal da página -->
        <p>principal elo da engrenagem da atividade paraquedista.</p> <!-- Descrição ou subtítulo da página -->
    </div>

    <!-- Container com botões de navegação -->
    <div class="button-container">
        <!-- Cada link leva o usuário para diferentes páginas -->
        <a href="inspecao_inicial.php" class="button">Inspeção Inicial</a> <!-- Link para inspeção inicial -->
        <a href="inspecao_final.php" class="button">Inspeção Final</a> <!-- Link para inspeção final -->
        <a href="paraquedas_manutencao.php" class="button">Paraquedas em Manutenção</a> <!-- Link para paraquedas em manutenção -->
        <a href="paraquedas_manutenidos.php" class="button">Paraquedas Manutenido</a> <!-- Link para paraquedas que já foram manutenidos -->
    </div>

    <!-- Script para carregar conteúdo dinamicamente -->
    <script>
        // Define uma função para carregar páginas de forma dinâmica
        function loadPage(page) {
            // Faz uma requisição HTTP para carregar o conteúdo da página especificada
            fetch(page)
            .then(response => response.text()) // Converte a resposta em texto
            .then(data => {
                // Insere o conteúdo da página carregada dentro do elemento com o ID 'content'
                document.getElementById('content').innerHTML = data;
            })
            .catch(error => {
                // Exibe um erro no console se ocorrer algum problema durante o carregamento
                console.error('Erro ao carregar a página:', error);
            });
        }
    </script>

</body>
</html>
