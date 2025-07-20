<?php

require_once 'pedidos.php';
require_once 'carrinho_compras.php';
require_once 'config.php';

// TESTE PED-001 : 

function testarCriacaoPedidoCarrinhoValido() {
    global $GLOBALS;

    $produto1Id = 1; 
    $produto1Quantidade = 1;
    $produto2Id = 2; 
    $produto2Quantidade = 1;

    $estoqueInicialProd1 = $GLOBALS['produtos'][$produto1Id]['estoque'];
    $estoqueInicialProd2 = $GLOBALS['produtos'][$produto2Id]['estoque'];

    $GLOBALS['carrinho'] = [];

    $setupResult1 = adicionar_item_carrinho($produto1Id, $produto1Quantidade);
    $setupResult2 = adicionar_item_carrinho($produto2Id, $produto2Quantidade);

    if ($setupResult1['status'] !== 'sucesso' || $setupResult2['status'] !== 'sucesso') {
        echo "PED-001 - ERRO DE SETUP: Falha ao adicionar itens ao carrinho. Resultado Camiseta: " . $setupResult1['mensagem'] . ". Resultado Calça Jeans: " . $setupResult2['mensagem'] . "\n";
        return false;
    }
    echo "PED-001 : Setup => Carrinho preenchido com Camiseta (Qtd 1) e Calça Jeans (Qtd 1).\n";

    $resultadoPedido = criar_pedido($GLOBALS['carrinho']);

    if ($resultadoPedido['status'] !== 'sucesso' || !isset($resultadoPedido['pedido']) || !is_array($resultadoPedido['pedido'])) {
        echo "PED-001 - Falha na criação do pedido: Status ou formato do retorno inválido.\n";
        print_r($resultadoPedido);
        return false;
    }

    $pedidoCriado = $resultadoPedido['pedido'];

    $estoqueEsperadoProd1 = $estoqueInicialProd1 - $produto1Quantidade; 
    $estoqueEsperadoProd2 = $estoqueInicialProd2 - $produto2Quantidade;

    if ($GLOBALS['produtos'][$produto1Id]['estoque'] !== $estoqueEsperadoProd1 ||
        $GLOBALS['produtos'][$produto2Id]['estoque'] !== $estoqueEsperadoProd2) {
        echo "PED-001 - Falha no decremento de estoque. \n";
        echo "Estoque Camiseta: Esperado {$estoqueEsperadoProd1}, Real {$GLOBALS['produtos'][$produto1Id]['estoque']}\n";
        echo "Estoque Calça Jeans: Esperado {$estoqueEsperadoProd2}, Real {$GLOBALS['produtos'][$produto2Id]['estoque']}\n";
        return false;
    }

    if (!empty($GLOBALS['carrinho'])) {
        echo "PED-001 - Falha: Carrinho não está vazio após a criação do pedido.\n";
        print_r($GLOBALS['carrinho']);
        return false;
    }

    if ($pedidoCriado['status'] !== 'pendente') {
        echo "PED-001 - Falha: Status do pedido não é 'pendente'. Status real: {$pedidoCriado['status']}.\n";
        print_r($pedidoCriado);
        return false;
    }

    echo "PED-001 : Mensagem => Criação de pedido com carrinho válido passou. ID do Pedido: {$pedidoCriado['id']}. Estoques atualizados e carrinho vazio.\n";
    return true;
}

// TESTE PED-002 : 

function testarCriacaoPedidoCarrinhoVazio() {
    global $GLOBALS;

    $GLOBALS['carrinho'] = [];

    $resultado = criar_pedido($GLOBALS['carrinho']);

    if ($resultado['status'] === 'erro' &&
        $resultado['mensagem'] === 'Carrinho de compras vazio. Não é possível criar um pedido.') {
        echo "PED-002 : Mensagem => Criação de pedido com carrinho vazio falhou como esperado. Status: {$resultado['status']}, Mensagem: {$resultado['mensagem']}.\n";
        return true;
    } else {
        echo "PED-002 - Falha: Criação de pedido com carrinho vazio retornou resultado inesperado.\n";
        print_r($resultado);
        return false;
    }
}

// TESTE PED-003 : 

function testarCriacaoPedidoProdutoInexistente() {
    global $GLOBALS;

    $GLOBALS['carrinho'] = [];

    // ADICIONADO AO CARRINHO UM PRODUTO INEXISTENTE NO CATÁLOGO DE PROTUDOS
    $GLOBALS['carrinho'][99] = ['id' => 99, 'nome' => 'Item Inexistente', 'preco' => 10.00, 'quantidade' => 1];

    $resultado = criar_pedido($GLOBALS['carrinho']);

    $mensagemEsperada = 'Produto não existe no catálogo: ID 99';
    if ($resultado['status'] === 'erro' && $resultado['mensagem'] === $mensagemEsperada) {
        echo "PED-003 : Mensagem => Criação de pedido com produto inexistente falhou como esperado. Status: {$resultado['status']}, Mensagem: {$resultado['mensagem']}.\n";
        return true;
    } else {
        echo "PED-003 - Falha: Criação de pedido com produto inexistente retornou resultado inesperado.\n";
        print_r($resultado);
        return false;
    }
}

// TESTE PED-004 : 

function testarAtualizacaoStatusPedidoTransicaoValida() {
    global $GLOBALS;

    $produto1Id = 1;
    adicionar_item_carrinho($produto1Id, 1);
    $resultadoCriacaoPedido = criar_pedido($GLOBALS['carrinho']);

    if ($resultadoCriacaoPedido['status'] !== 'sucesso') {
        echo "PED-004 - ERRO DE SETUP: Falha ao criar pedido inicial. " . $resultadoCriacaoPedido['mensagem'] . "\n";
        return false;
    }

    $pedidoId = $resultadoCriacaoPedido['pedido']['id'];
    echo "PED-004 : Setup => Pedido #{$pedidoId} criado com status 'pendente'.\n";

    if ($GLOBALS['pedidos'][$pedidoId]['status'] !== 'pendente') {
        echo "PED-004 - ERRO DE SETUP: Pedido #{$pedidoId} não está com status 'pendente' inicialmente.\n";
        return false;
    }

    $resultadoAtualizacao = atualizar_status_pedido($pedidoId, 'processando');

    if ($resultadoAtualizacao['status'] !== 'sucesso') {
        echo "PED-004 - Falha na atualização do status: Retornou erro. Mensagem: {$resultadoAtualizacao['mensagem']}\n";
        print_r($resultadoAtualizacao);
        return false;
    }

    if ($GLOBALS['pedidos'][$pedidoId]['status'] !== 'processando') {
        echo "PED-004 - Falha: Status do pedido #{$pedidoId} não foi atualizado para 'processando'. Status atual: {$GLOBALS['pedidos'][$pedidoId]['status']}\n";
        return false;
    }

    echo "PED-004 : Mensagem => Atualização de status de pedido (pendente para processando) passou com sucesso. Pedido #{$pedidoId} agora é 'processando'.\n";
    return true;
}

// TESTE PED-005 : 

function testarAtualizacaoStatusPedidoTransicaoInvalida() {
    global $GLOBALS;

    $produto1Id = 1;
    adicionar_item_carrinho($produto1Id, 1);
    $resultadoCriacaoPedido = criar_pedido($GLOBALS['carrinho']);

    if ($resultadoCriacaoPedido['status'] !== 'sucesso') {
        echo "PED-005 - ERRO DE SETUP: Falha ao criar pedido inicial. " . $resultadoCriacaoPedido['mensagem'] . "\n";
        return false;
    }

    $pedidoId = $resultadoCriacaoPedido['pedido']['id'];
    echo "PED-005 : Setup => Pedido #{$pedidoId} criado com status 'pendente'.\n";

    $atualizacao1 = atualizar_status_pedido($pedidoId, 'processando');
    $atualizacao2 = atualizar_status_pedido($pedidoId, 'enviado');
    $atualizacao3 = atualizar_status_pedido($pedidoId, 'entregue');

    if ($atualizacao1['status'] !== 'sucesso' || $atualizacao2['status'] !== 'sucesso' || $atualizacao3['status'] !== 'sucesso') {
        echo "PED-005 - ERRO DE SETUP: Falha ao mudar status para 'entregue'. \n";
        print_r($atualizacao1);
        print_r($atualizacao2);
        print_r($atualizacao3);
        return false;
    }
    if ($GLOBALS['pedidos'][$pedidoId]['status'] !== 'entregue') {
        echo "PED-005 - ERRO DE SETUP: Status do pedido #{$pedidoId} não é 'entregue' após setup. Status: " . $GLOBALS['pedidos'][$pedidoId]['status'] . "\n";
        return false;
    }
    echo "PED-005 : Setup => Pedido #{$pedidoId} alterado para status 'entregue'.\n";

    $resultadoAtualizacao = atualizar_status_pedido($pedidoId, 'processando');

    if ($resultadoAtualizacao['status'] !== 'erro') {
        echo "PED-005 - Falha: Atualização de status inválida não retornou erro. Retorno: \n";
        print_r($resultadoAtualizacao);
        return false;
    }

    $mensagemEsperada = "Transição de status inválida de 'entregue' para 'processando'. Alteração não permitida.";
    if ($resultadoAtualizacao['mensagem'] !== $mensagemEsperada) {
        echo "PED-005 - Falha: Mensagem de erro inesperada. Esperado: '{$mensagemEsperada}', Recebido: '{$resultadoAtualizacao['mensagem']}'.\n";
        return false;
    }

    echo "PED-005 : Mensagem => Atualização de status de pedido (entregue para processando) falhou como esperado. Status: {$resultadoAtualizacao['status']}, Mensagem: {$resultadoAtualizacao['mensagem']}.\n";
    return true;
}



?>