<?php

require_once 'produtos_catalogo.php';
require_once 'config.php';

// MÓDULO 01 = PRODUTOS E CATÁLOGOS

// TESTE PROD-001 : VALIDAÇÃO DE PRODUTO VÁLIDO

function validarProdutoValido()
{
    $result = validar_produto('camiseta', 29.90, 'Camiseta de algodão', 50); // PARÂMETROS SEM ERROS

    if ($result['status'] === 'sucesso'){
        echo "PROD-001 : Mensagem => Passou no teste validar produto válido. Status => " . $result['status']. "\n";
        return true;
    }
    else {
        echo "Não passou no teste validar produto válido. \n";
        print_r($result['mensagens']);
        return false;
    }
}

// TESTE PROD-002 : VALIDAÇÃO DE PRODUTO COM NOME VAZIO

function validarProdutoNomeVazio()
{
    $result = validar_produto('  ', 50.00, 'Vestido de verão', 10); // PARÂMETRO NOME COM ESPAÇOS (SIMULANDO SER VAZIO)

    if ($result['status'] === 'erro') {
        echo "PROD-002 : Mensagem => " . implode(', ', $result['mensagens']) . " Status => {$result['status']} \n";
        return true;
    } else {
        echo "Esperava erro, mas retornou sucesso.\n";
        return false;
    }
}

// TESTE PROD-003 : VALIDAÇÃO DE PRODUTO COM PREÇO NEGATIVOS

function validarProdutoPrecoNegativo()
{
    $result = validar_produto('Meia Esportiva', -10.00, 'Par de meias', 100); // PARÂMETRO PREÇO NEGATIVO

    if ($result['status'] === 'erro'){
        echo "PROD-003 : Mensagem => " . implode(', ', $result['mensagens']) . " Status => {$result['status']} \n";
        return true;
    } else {
        echo "Esperava erro, mas retornou sucesso. \n";
        return false;
    }
}

// TESTE PROD-004 : 

function validarProdutoEstoqueNaoNumerico()
{
    $result = validar_produto('Cinto de Couro', 75.00, 'Cinto marrom', 'vinte'); // PARÀMETRO ESTOQUE NÃO NUMÉRICO

    if ($result['status'] === 'erro'){
        echo "PROD-004 : Mensagem => " . implode(', ', $result['mensagens']) . " Status => {$result['status']} \n";
        return true;
    } else {
        echo "Esperava erro, mas retornou sucesso. \n";
        return false;
    }
}

// TESTE PROD-005 : 

function testarBuscaPorNome() {

    $busca = 'Camiseta';
    $result = buscar_produtos($busca, 'nome');

    if (count($result) === 1 && $result[0]['nome'] === $busca) {
        echo "PROD-005 : Mensagem => Busca por nome passou. Array contendo o produto: {$result[0]['nome']} \n";
        return true;
    } else {
        echo "PROD-005 - Falha na busca por nome.\n";
        print_r($result);
        return false;
    }
}

// TESTE PROD-006 : 

function testarBuscaPorCategoria() 
{
    $termoBusca = 'Roupas';
    $tipoBusca = 'categoria';

    $result = buscar_produtos($termoBusca, $tipoBusca);

    if (count($result) === 2 && isset($result[0]['nome']) && $result[0]['nome'] === 'Camiseta' &&
        isset($result[1]['nome']) && $result[1]['nome'] === 'Calça Jeans') {
        echo "PROD-006 : Mensagem => Busca por categoria passou. Encontrados: '{$result[0]['nome']}' e '{$result[1]['nome']}' \n";
        return true;
    } else {
        echo "PROD-006 - Falha na busca por categoria para '{$termoBusca}'.\n";
        echo "Resultado obtido:\n";
        print_r($result);
        return false;
    }
}

// TESTE PROD-007 :

function testarBuscaPorId() {

    // PASSANDO O ID COMO INT :

    $resultadoInt = buscar_produtos(2, 'id');
    $passouInt = (count($resultadoInt) === 1 && isset($resultadoInt[0]['id']));

    if ($passouInt) {
        echo "PROD-007 (Passo 1) : Mensagem => Busca por ID (int) passou. Encontrado: '{$resultadoInt[0]['nome']}' \n";
    } else {
        echo "PROD-007 (Passo 1) - Falha na busca por ID (inteiro).\n";
        echo "Resultado obtido:\n";
        print_r($resultadoInt);
        return false;
    }

    // AGORA PASSANDO ID COMO STRING 
    $resultadoString = buscar_produtos('2', 'id');
    $passouString = (count($resultadoString) === 1 && isset($resultadoString[0]['id']));

    if ($passouString) {
        echo "PROD-007 (Passo 2) : Mensagem => Busca por ID (string) passou. Encontrado: '{$resultadoString[0]['nome']}' \n";
        return true;
    } else {
        echo "PROD-007 (Passo 2) - Falha na busca por ID (string).\n";
        echo "Resultado obtido:\n";
        print_r($resultadoString);
        return false;
    }
}

// TESTE PROD-008 : 

function testarAtualizarEstoqueDecremento() {
    global $GLOBALS;

    $produtoId = 1;
    $quantidadeDecremento = -10;
    $estoqueEsperadoInicial = 50;
    $estoqueEsperadoFinal = 40;

    if (!isset($GLOBALS['produtos'][$produtoId])) {
        echo "PROD-008 - ERRO: Produto ID {$produtoId} não encontrado nas pré-condições globais.\n";
        return false;
    }
    $GLOBALS['produtos'][$produtoId]['estoque'] = $estoqueEsperadoInicial;

    $resultado = atualizar_estoque($produtoId, $quantidadeDecremento);

    if ($resultado['status'] === 'sucesso' &&
        isset($GLOBALS['produtos'][$produtoId]['estoque']) &&
        $GLOBALS['produtos'][$produtoId]['estoque'] === $estoqueEsperadoFinal
    ) {
        echo "PROD-008 : Mensagem => Atualização de estoque (decremento) passou. Status: '{$resultado['status']}'. Novo estoque da Camiseta: {$GLOBALS['produtos'][$produtoId]['estoque']}.\n";
        return true;
    } else {
        echo "PROD-008 - Falha na atualização de estoque (decremento).\n";
        echo "Resultado da função: ";
        print_r($resultado);
        echo "Estoque atual da Camiseta (ID {$produtoId}): " . ($GLOBALS['produtos'][$produtoId]['estoque'] ?? 'N/A') . "\n";
        return false;
    }
}

// TESTE PROD-009 : 

function testarAtualizacaoEstoqueInsuficiente() {
    global $GLOBALS;

    $produtoId = 3;
    $quantidadeDecremento = -25;
    $estoqueEsperadoInicial = 20; 
    $mensagemErroEsperada = 'Estoque insuficiente para esta operação.';

    if (!isset($GLOBALS['produtos'][$produtoId])) {
        echo "PROD-009 - ERRO: Produto ID {$produtoId} não encontrado.\n";
        return false;
    }

    $GLOBALS['produtos'][$produtoId]['estoque'] = $estoqueEsperadoInicial;

    $resultado = atualizar_estoque($produtoId, $quantidadeDecremento);

    if ($resultado['status'] === 'erro' &&
        $resultado['mensagem'] === $mensagemErroEsperada &&
        isset($GLOBALS['produtos'][$produtoId]['estoque']) &&
        $GLOBALS['produtos'][$produtoId]['estoque'] === $estoqueEsperadoInicial 
    ) {
        echo "PROD-009 : Mensagem => Atualização de estoque (insuficiente) passou. Status: '{$resultado['status']}'. Mensagem: '{$resultado['mensagem']}'. Estoque permaneceu: {$GLOBALS['produtos'][$produtoId]['estoque']}.\n";
        return true;
    } else {
        echo "PROD-009 - Falha na atualização de estoque (insuficiente).\n";
        echo "Resultado da função: ";
        print_r($resultado);
        echo "Estoque atual do Tênis Esportivo (ID {$produtoId}): " . ($GLOBALS['produtos'][$produtoId]['estoque'] ?? 'N/A') . "\n";
        return false;
    }
}


?>