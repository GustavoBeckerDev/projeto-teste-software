<?php
// carrinho_compras.php
require_once __DIR__ . '/config.php'; // Inclui as variáveis globais
require_once 'produtos_catalogo.php'; // Caso use a função buscar_produtos
// Pode precisar incluir produtos_catalogo.php se for interagir diretamente com buscar_produtos, por exemplo.
// Para o cenário atual, ele acessa $GLOBALS['produtos'] diretamente.
/**
 * Adiciona ou atualiza um item no carrinho.
 * @param int $produto_id ID do produto.
 * @param int $quantidade Quantidade a adicionar.
 * @return array Status da operação (sucesso/erro) e mensagem.
 */
function adicionar_item_carrinho($produto_id, $quantidade) {
    // Mock: Obter detalhes do produto (simula um serviço externo ou banco de dados)
    if (!isset($GLOBALS['produtos'][$produto_id])) {
        return ['status' => 'erro', 'mensagem' => 'Produto não existe no catálogo.'];
    }

    if (!is_numeric($quantidade) || $quantidade <= 0 || floor($quantidade) != $quantidade) {
        return ['status' => 'erro', 'mensagem' => 'Quantidade inválida para adicionar ao carrinho.'];
    }

    $produto = $GLOBALS['produtos'][$produto_id];

    $quantidade_a_adicionar = $quantidade; // RETIREI O * 2 POIS NÃO FAZ SENTIDO DUPLICAR A ADIÇÃO DO USUÁRIO

    if (isset($GLOBALS['carrinho'][$produto_id])) {
        $GLOBALS['carrinho'][$produto_id]['quantidade'] += $quantidade_a_adicionar;
    } else {
        $GLOBALS['carrinho'][$produto_id] = [
            'id' => $produto_id,      // BUG SUTIL RESOLVIDO, EU CRIAVA O CARRINHO APENAS COM ID E QUANTIDADE, ADICIONEI NOME E PREÇO
            'nome' => $produto['nome'], // NOME ADICIONADO
            'preco' => $produto['preco'], // PRECO ADICIONADO
            'quantidade' => $quantidade_a_adicionar
        ];
    }
    return ['status' => 'sucesso', 'mensagem' => 'Item adicionado/atualizado no carrinho.'];
}

/**
 * Remove um item do carrinho.
 * @param int $produto_id ID do produto a ser removido.
 * @return array Status da operação (sucesso/erro) e mensagem.
 */
function remover_item_carrinho($produto_id) {
    if (!isset($GLOBALS['carrinho'][$produto_id])) {
        return ['status' => 'erro', 'mensagem' => 'Item não encontrado no carrinho.'];
    }
    unset($GLOBALS['carrinho'][$produto_id]);
    return ['status' => 'sucesso', 'mensagem' => 'Item removido do carrinho.'];
}

/**
 * Atualiza a quantidade de um item no carrinho.
 * @param int $produto_id ID do produto.
 * @param int $nova_quantidade Nova quantidade para o item.
 * @return array Status da operação (sucesso/erro) e mensagem.
 */
function atualizar_quantidade_item_carrinho($produto_id, $nova_quantidade) {
    if (!isset($GLOBALS['carrinho'][$produto_id])) {
        return ['status' => 'erro', 'mensagem' => 'Item não encontrado no carrinho para atualização.'];
    }

    if (!is_numeric($nova_quantidade) || floor($nova_quantidade) != $nova_quantidade) {
        return ['status' => 'erro', 'mensagem' => 'Quantidade inválida para atualização.'];
    }

    if ($nova_quantidade <= 0) {
        return remover_item_carrinho($produto_id); // Se a quantidade for zero ou menos, remove
    }

    $GLOBALS['carrinho'][$produto_id]['quantidade'] = $nova_quantidade;
    return ['status' => 'sucesso', 'mensagem' => 'Quantidade do item atualizada.'];
}

/**
 * Calcula o valor total do carrinho.
 * @return float Valor total do carrinho.
 */
function calcular_total_carrinho() {
    $total = 0.0;
    foreach ($GLOBALS['carrinho'] as $item) {
        $total += $item['preco'] * $item['quantidade'];
    }
    return $total;
}
?>