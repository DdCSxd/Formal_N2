<?php

// Verifica se a URL contém um parâmetro chamado 'status'
if (isset($_GET['status'])) {
    // Se o valor do parâmetro 'status' for 'sucesso', exibe um alerta de sucesso
    if ($_GET['status'] == 'sucesso') {
        echo "<script>alert('Cadastro de inspeção realizado com sucesso!');</script>";
    // Se o valor do parâmetro 'status' for 'erro' e houver uma mensagem de erro na URL
    } else if ($_GET['status'] == 'erro' && isset($_GET['message'])) {
        // Decodifica a mensagem de erro que vem na URL
        $error_message = urldecode($_GET['message']);
        // Exibe a mensagem de erro em um alerta
        echo "<script>alert('$error_message');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define a codificação de caracteres da página como UTF-8 -->
    <meta charset="UTF-8">
    <!-- Ajusta a página para ser responsiva em diferentes dispositivos -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link para o arquivo de estilo CSS da página -->
    <link rel="stylesheet" href="inspecao_inicial.css">
    <!-- Define o ícone da página (favicon) que aparece na guia do navegador -->
    <link rel="shortcut icon" type="imagex/png" href="imagens/breve_aux-removebg-preview.png">
    <!-- Define o título da página que aparece na guia do navegador -->
    <title>Inspeção Inicial</title>
</head>
<body>
    <!-- Cabeçalho da página com o título -->
    <h1>Inspeção Inicial</h1>
   

    <!-- Formulário onde o usuário vai preencher os dados da inspeção -->
    <form action="process_inspection.php" method="post">
        <!-- Campo para selecionar o tipo de PQD (paraquedas) -->
        <label>Tipo de PQD:</label>
        <div class="checkbox-group">
            <!-- Opções de PQD com checkboxes -->
            <label><input type="checkbox" name="tipo_pqd[]" value="T10-B"> T10-B</label>
            <label><input type="checkbox" name="tipo_pqd[]" value="T10-R"> T10-R</label>
            <label><input type="checkbox" name="tipo_pqd[]" value="MC1-1C"> MC1-1C</label>
        </div>

        <!-- Campo para o usuário informar a data de fabricação do paraquedas -->
        <label>Data de Fabricação:</label>
        <input type="date" name="data_fabricacao" placeholder="Digite o ano (ex: 02/2024)" required>

        <!-- Campo para o usuário informar o número do velame -->
        <label>Número do Velame:</label>
        <input type="number" name="numero_velame" placeholder="Digite o número do velame" required>

        <!-- Campo para o usuário informar o número do invólucro -->
        <label>Número do Invólucro:</label>
        <input type="number" name="numero_involucro" placeholder="Digite o número do invólucro" required>

        <!-- Campo para informar o número do auxiliar que está fazendo a inspeção -->
        <label>Inspecionado por (Aux N):</label>
        <input type="number" name="inspecionado_por" placeholder="Digite o N Aux." required>

        <!-- Campo para o usuário informar a data da inspeção -->
        <label>Data da Inspeção:</label>
        <input type="date" name="data_inspecao" required>

        <!-- Campo para o usuário escrever observações sobre a inspeção -->
        <label>Observações:</label>
        <textarea name="observacoes" rows="4" placeholder="Digite as observações"></textarea>

        <!-- Bloco de opções para tipos de reparo ou manutenção -->
        <div class="checkbox-group">
            
            <!-- Opção para indicar se o paraquedas teve remendo -->
            <label>
                <input type="checkbox" name="remendo" id="remendo_checkbox" onclick="toggleFields('remendo')"> Remendo
            </label>
            <!-- Campos que aparecem se a opção "remendo" for marcada -->
            <div id="remendo_fields" class="hidden-fields">
                <label for="remendo_painel">Número do painel (1-30):</label>
                <input type="number" id="remendo_painel" name="remendo_painel" min="1" max="30">
                
                <label for="remendo_secao">Número da seção (1-4):</label>
                <input type="number" id="remendo_secao" name="remendo_secao" min="1" max="4">
            </div>

            <!-- Opção para indicar se houve substituição de partes do paraquedas -->
            <label>
                <input type="checkbox" name="substituicao" id="substituicao_checkbox" onclick="toggleFields('substituicao')"> Substituição
            </label>
            <!-- Campos que aparecem se a opção "substituição" for marcada -->
            <div id="substituicao_fields" class="hidden-fields">
                <label for="substituicao_painel">Número do painel (1-30):</label>
                <input type="number" id="substituicao_painel" name="substituicao_painel" min="1" max="30">
                
                <label for="substituicao_secao">Número da seção (1-4):</label>
                <input type="number" id="substituicao_secao" name="substituicao_secao" min="1" max="4">
            </div>

            <!-- Opção para indicar se houve recostura de partes do paraquedas -->
            <label>
                <input type="checkbox" name="recostura" id="recostura_checkbox" onclick="toggleFields('recostura')"> Recostura
            </label>
            <!-- Campos que aparecem se a opção "recostura" for marcada -->
            <div id="recostura_fields" class="hidden-fields">
                <label for="recostura_painel">Número do painel (1-30):</label>
                <input type="number" id="recostura_painel" name="recostura_painel" min="1" max="30">
                
                <label for="recostura_secao">Número da seção (1-4):</label>
                <input type="number" id="recostura_secao" name="recostura_secao" min="1" max="4">
            </div>

            <!-- Opção para indicar se houve troca de linhas do paraquedas -->
            <label>
                <input type="checkbox" name="troca_linha" id="troca_linha_checkbox" onclick="toggleFields('troca_linha')"> Troca de Linhas
            </label>
            <!-- Campos que aparecem se a opção "troca de linhas" for marcada -->
            <div id="troca_linha_fields" class="hidden-fields">
                <label for="troca_linha_numero">Número da linha (1-30):</label>
                <input type="number" id="troca_linha_numero" name="troca_linha_numero" min="1" max="30">
            </div>
        </div>

        <!-- Script para mostrar ou esconder os campos adicionais conforme as opções de reparo -->
        <script>
            function toggleFields(type) {
                var checkbox = document.getElementById(type + '_checkbox');
                var fields = document.getElementById(type + '_fields');
                
                if (checkbox.checked) {
                    fields.style.display = 'block'; // Exibe os campos se a opção for marcada
                } else {
                    fields.style.display = 'none'; // Esconde os campos se a opção não for marcada
                }
            }
        </script>

        <!-- Botão para enviar o formulário -->
        <input type="submit" value="Enviar" class="button">
    </form>

    <!-- Link para voltar à página inicial -->
    <footer><a href="dashboard.php" class="button">Voltar para tela inicial</a></footer>
</body>
</html>
