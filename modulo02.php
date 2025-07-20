<?php

require_once 'carrinho_compras.php';
require_once 'config.php';

// TESTE CARR-001 :

function testeAdicionarNovoItemCarrinho() {
    global $GLOBALS;

    $GLOBALS['carrinho'] = [];

    $produtoId = 1;
    $quantidadeEsperada = 2;
    $nomeProdutoEsperado = 'Camiseta';
    $precoProdutoEsperado = 29.90;

    $resultadoAdicao = adicionar_item_carrinho($produtoId, $quantidadeEsperada);

    if ($resultadoAdicao['status'] === 'sucesso' &&
        isset($GLOBALS['carrinho'][$produtoId]) &&
        $GLOBALS['carrinho'][$produtoId]['quantidade'] === $quantidadeEsperada &&
        $GLOBALS['carrinho'][$produtoId]['nome'] === $nomeProdutoEsperado &&
        $GLOBALS['carrinho'][$produtoId]['preco'] === $precoProdutoEsperado
    ) {
        echo "CARR-001 : Mensagem => Adição de novo item ao carrinho passou. Status: '{$resultadoAdicao['status']}'. Item: '{$GLOBALS['carrinho'][$produtoId]['nome']}', Quantidade: {$GLOBALS['carrinho'][$produtoId]['quantidade']}.\n";
        return true;
    } else {
        echo "CARR-001 - Falha ao adicionar novo item ao carrinho.\n";
        echo "Resultado da função: ";
        print_r($resultadoAdicao);
        echo "Estado atual do carrinho:\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }
}

// TESTE CARR-002 : 

function testeAdicionarItemExistenteCarrinho() {
    global $GLOBALS; 
    $produtoId = 1;
    $quantidadeInicial = 2;
    $quantidadeAdicionar = 3;
    $quantidadeEsperadaFinal = $quantidadeInicial + $quantidadeAdicionar;
    $nomeProdutoEsperado = 'Camiseta';
    $precoProdutoEsperado = 29.90;
    $GLOBALS['carrinho'] = [];
    if (!isset($GLOBALS['produtos'][$produtoId])) {
        echo "CARR-002 - ERRO: Produto ID {$produtoId} (Camiseta) não encontrado no catálogo global.\n";
        return false;
    }
    $GLOBALS['carrinho'][$produtoId] = 
    [
        'id' => $produtoId,
        'nome' => $nomeProdutoEsperado,
        'preco' => $precoProdutoEsperado,
        'quantidade' => $quantidadeInicial
    ];

    $resultadoAdicao = adicionar_item_carrinho($produtoId, $quantidadeAdicionar);

    if ($resultadoAdicao['status'] === 'sucesso' &&
        isset($GLOBALS['carrinho'][$produtoId]) &&
        $GLOBALS['carrinho'][$produtoId]['quantidade'] === $quantidadeEsperadaFinal &&
        $GLOBALS['carrinho'][$produtoId]['nome'] === $nomeProdutoEsperado &&
        $GLOBALS['carrinho'][$produtoId]['preco'] === $precoProdutoEsperado
    ) {
        echo "CARR-002 : Mensagem => Adição de item existente ao carrinho passou. Status: '{$resultadoAdicao['status']}'. Nova Quantidade da Camiseta: {$GLOBALS['carrinho'][$produtoId]['quantidade']}.\n";
        return true;
    } else {
        echo "CARR-002 - Falha ao adicionar item existente ao carrinho.\n";
        echo "Resultado da função: ";
        print_r($resultadoAdicao);
        echo "Estado atual do carrinho:\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }
}

// TESTE CARR-003

function testarRemoverItemCarrinho() {
    global $GLOBALS;
    $produtoId = 2;
    $quantidadeInicial = 3;
    $GLOBALS['carrinho'] = [];

    $setupResultado = adicionar_item_carrinho($produtoId, $quantidadeInicial);

    if ($setupResultado['status'] !== 'sucesso') {
        echo "CARR-003 - ERRO DE SETUP: Falha ao adicionar item para pré-condição. Status: {$setupResultado['status']}, Mensagem: {$setupResultado['mensagem']}\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }

    $resultadoRemocao = remover_item_carrinho($produtoId);

    if ($resultadoRemocao['status'] === 'sucesso' &&
        !isset($GLOBALS['carrinho'][$produtoId])
    ) {
        echo "CARR-003 : Mensagem => Remoção de item do carrinho passou. Status: '{$resultadoRemocao['status']}'. Item ID {$produtoId} não encontrado no carrinho, como esperado.\n";
        return true;
    } else {
        echo "CARR-003 - Falha ao remover item do carrinho.\n";
        echo "Resultado da função: ";
        print_r($resultadoRemocao);
        echo "Estado atual do carrinho:\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }
}

// TESTE CARR-004 :

function testarAtualizarQuantidadeItemCarrinho() {
    global $GLOBALS;

    $produtoId = 3;
    $quantidadeInicial = 5;
    $novaQuantidade = 2;

    $GLOBALS['carrinho'] = [];

    $setupResultado = adicionar_item_carrinho($produtoId, $quantidadeInicial);

    if ($setupResultado['status'] !== 'sucesso') {
        echo "CARR-004 - ERRO DE SETUP: Falha ao adicionar item para pré-condição. Status: {$setupResultado['status']}, Mensagem: {$setupResultado['mensagem']}\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }

    $resultadoAtualizacao = atualizar_quantidade_item_carrinho($produtoId, $novaQuantidade);

    if ($resultadoAtualizacao['status'] === 'sucesso' &&
        isset($GLOBALS['carrinho'][$produtoId]) &&
        $GLOBALS['carrinho'][$produtoId]['quantidade'] === $novaQuantidade
    ) {
        echo "CARR-004 : Mensagem => Atualização de quantidade de item no carrinho passou. Status: '{$resultadoAtualizacao['status']}'. Nova Quantidade do Tênis Esportivo: {$GLOBALS['carrinho'][$produtoId]['quantidade']}.\n";
        return true;
    } else {
        echo "CARR-004 - Falha ao atualizar quantidade de item no carrinho.\n";
        return false;
    }
}

// TESTE CARR-005 : 

function testarAtualizarQuantidadeParaZero() {
    global $GLOBALS;

    $produtoId = 3;
    $quantidadeInicial = 1;
    $novaQuantidade = 0;

    $GLOBALS['carrinho'] = [];

    $setupResultado = adicionar_item_carrinho($produtoId, $quantidadeInicial);

    if ($setupResultado['status'] !== 'sucesso') {
        echo "CARR-005 - ERRO DE SETUP: Falha ao adicionar item para pré-condição. Status: {$setupResultado['status']}, Mensagem: {$setupResultado['mensagem']}\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }

    $resultadoAtualizacao = atualizar_quantidade_item_carrinho($produtoId, $novaQuantidade);

    if ($resultadoAtualizacao['status'] === 'sucesso' &&
        !isset($GLOBALS['carrinho'][$produtoId])
    ) {
        echo "CARR-005 : Mensagem => Atualização de quantidade para zero (remoção) passou. Status: '{$resultadoAtualizacao['status']}'. Item ID {$produtoId} não encontrado no carrinho, como esperado.\n";
        return true;
    } else {
        echo "CARR-005 - Falha na atualização de quantidade para zero (remoção).\n";
        echo "Resultado da função: ";
        print_r($resultadoAtualizacao);
        echo "Estado atual do carrinho:\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }
}

// TESTE CARR-006 : 

function testarCalcularTotalCarrinho() {
    global $GLOBALS;

    $produto1Id = 1;
    $produto1Quantidade = 2;
    $produto1Preco = $GLOBALS['produtos'][$produto1Id]['preco']; // 2 * 29.90 = 59.80

    $produto2Id = 2; 
    $produto2Quantidade = 1;
    $produto2Preco = $GLOBALS['produtos'][$produto2Id]['preco']; // 1 * 89.90 = 89.90

    $produto3Id = 3; 
    $produto3Quantidade = 3;
    $produto3Preco = $GLOBALS['produtos'][$produto3Id]['preco']; // 3 * 150.00 = 450.00
  
    $totalEsperado = ($produto1Preco * $produto1Quantidade) + ($produto2Preco * $produto2Quantidade) + ($produto3Preco * $produto3Quantidade);
  
    $GLOBALS['carrinho'] = [];
    $setupResultado1 = adicionar_item_carrinho($produto1Id, $produto1Quantidade);
    $setupResultado2 = adicionar_item_carrinho($produto2Id, $produto2Quantidade);
    $setupResultado3 = adicionar_item_carrinho($produto3Id, $produto3Quantidade);

    if ($setupResultado1['status'] !== 'sucesso' || $setupResultado2['status'] !== 'sucesso' || $setupResultado3['status'] !== 'sucesso' ) {
        echo "CARR-006 - ERRO DE SETUP: Falha ao adicionar itens para pré-condição.\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }
   
    $totalReal = calcular_total_carrinho(); // 59.80 + 89.90 + 450.00 = 599.70

    if (abs($totalReal - $totalEsperado) < 0.001) {
        echo "CARR-006 : Mensagem => Cálculo do total do carrinho passou. Total Esperado: {$totalEsperado}, Total Real: {$totalReal}.\n";
        return true;
    } else {
        echo "CARR-006 - Falha no cálculo do total do carrinho.\n";
        echo "Total Esperado: {$totalEsperado}, Total Real: {$totalReal}.\n";
        echo "Estado atual do carrinho:\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }
}

?>