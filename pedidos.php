<?php
// pedidos.php
require_once __DIR__ . '/config.php'; // Inclui as variáveis globais
require_once __DIR__ . '/produtos_catalogo.php'; // Necessário para a função atualizar_estoque

/**
 * Adiciona ou atualiza um item no carrinho.
 * @param int $produto_id ID do produto.
 * @param int $quantidade Quantidade a adicionar.
 * @return array Status da operação (sucesso/erro) e mensagem.
 */

// Function adicionar_item_carrinho removida pois estava duplicada, ela já contêm no arquivo carrinho_compras.php

// Agora irei criar a função criar_pedido() pois está faltando nesse arquivo, ela é chamada la no meu arquivo de teste do modulo03.php

function criar_pedido($carrinho) {
    global $GLOBALS;

    if (empty($carrinho)) {
        return ['status' => 'erro', 'mensagem' => 'Carrinho de compras vazio. Não é possível criar um pedido.'];
    }

    $itens_pedido = [];
    $total_pedido = 0.0;
    $erros_estoque = [];

    foreach ($carrinho as $produto_id => $item) {
        if (!isset($GLOBALS['produtos'][$produto_id])) {
            return ['status' => 'erro', 'mensagem' => "Produto não existe no catálogo: ID {$produto_id}"];
        }

        $produto_catalogo = $GLOBALS['produtos'][$produto_id];

        if ($produto_catalogo['estoque'] < $item['quantidade']) {
            $erros_estoque[] = "Estoque insuficiente para '{$produto_catalogo['nome']}'. Disponível: {$produto_catalogo['estoque']}, Necessário: {$item['quantidade']}.";
        }
    }

    if (!empty($erros_estoque)) {
        return ['status' => 'erro', 'mensagem' => implode(' ', $erros_estoque)];
    }

    foreach ($carrinho as $produto_id => $item) {
        $itens_pedido[] = [
            'id' => $item['id'],
            'nome' => $item['nome'],
            'preco' => $item['preco'],
            'quantidade' => $item['quantidade'],
        ];
        $total_pedido += $item['preco'] * $item['quantidade'];

        $resultado_atualizacao_estoque = atualizar_estoque($produto_id, -$item['quantidade']);
        if ($resultado_atualizacao_estoque['status'] !== 'sucesso') {
             return ['status' => 'erro', 'mensagem' => 'Erro interno ao atualizar estoque para ' . $item['nome'] . ': ' . $resultado_atualizacao_estoque['mensagem']];
        }
    }

    $novo_pedido = [
        'id' => $GLOBALS['next_pedido_id']++, // Atribui um ID único e prepara o próximo ID, ++ É UM OPERADOR DE PÓS INCREMENTO
        'data' => date('Y-m-d H:i:s'),       // Data e hora exata da criação do pedido
        'itens' => $itens_pedido,            // Itens que estavam no carrinho no momento da compra
        'total' => $total_pedido,            // Valor total calculado do pedido
        'status' => 'pendente',              // Status inicial de qualquer novo pedido
    ];

    $GLOBALS['pedidos'][$novo_pedido['id']] = $novo_pedido;
    $GLOBALS['carrinho'] = [];
    return ['status' => 'sucesso', 'mensagem' => 'Pedido criado com sucesso.', 'pedido' => $novo_pedido];
}

/**
 * Atualiza o status de um pedido.
 * @param int $pedido_id ID do pedido.
 * @param string $novo_status O novo status desejado.
 * @return array Status da operação (sucesso/erro) e mensagem.
 */
function atualizar_status_pedido($pedido_id, $novo_status) {
    if (!isset($GLOBALS['pedidos'][$pedido_id])) {
        return ['status' => 'erro', 'mensagem' => 'Pedido não encontrado.'];
    }

    $status_validos = ['pendente', 'processando', 'enviado', 'entregue', 'cancelado'];
    if (!in_array($novo_status, $status_validos)) {
        return ['status' => 'erro', 'mensagem' => 'Status inválido: ' . $novo_status];
    }

    $pedido = &$GLOBALS['pedidos'][$pedido_id];
    $status_atual = $pedido['status'];

    // Lógica de transição de status (exemplo simples)
    $transicoes_validas = [
        'pendente' => ['processando', 'cancelado'],
        'processando' => ['enviado', 'cancelado'],
        'enviado' => ['entregue', 'cancelado'], // LINHA ADICIONADA, ADICIONADO CANCELADO COMO UMA TRANSIÇÃO VÁLIDA DO ENVIADO
        'entregue' => [], // ARRAY MODIFICADO, ENTREGUE VAZIO
        'cancelado' => [],
    ];

    if (!isset($transicoes_validas[$status_atual]) || !in_array($novo_status, $transicoes_validas[$status_atual])) {
        return ['status' => 'erro', 'mensagem' => "Transição de status inválida de '{$status_atual}' para '{$novo_status}'. Alteração não permitida."];
    }

    $pedido['status'] = $novo_status;
    return ['status' => 'sucesso', 'mensagem' => "Status do pedido {$pedido_id} atualizado para '{$novo_status}'.", 'novo_status' => $novo_status];
}
?>