<?php
// produtos_catalogo.php
require_once __DIR__ . '/config.php'; // Inclui as variáveis globais

/**
 * Valida os dados de entrada de um novo produto.
 * @param string $nome Nome do produto.
 * @param float $preco Preço do produto.
 * @param string $descricao Descrição do produto.
 * @param int $estoque Quantidade em estoque.
 * @return array Array associativo com status e mensagem de erro, se houver.
 */
function validar_produto($nome, $preco, $descricao, $estoque) {
    $erros = [];

    if (empty(trim($nome))) {
        $erros[] = "Nome do produto não pode ser vazio."; // BUG RESOLVIDO
    }
    if (!is_numeric($preco) || $preco <= 0) {
        $erros[] = "Preço deve ser um número positivo.";
    }
    if (empty($descricao)) {
        $erros[] = "Descrição do produto não pode ser vazia.";
    }
    if (!is_numeric($estoque) || $estoque < 0 || floor($estoque) != $estoque) {
        $erros[] = "Estoque deve ser um número inteiro não negativo.";
    }
    
    // $erros[] = "ERRO EXPLÍCITO DE VALIDAÇÃO."; 
    // RETIREI ESSA LINHA POIS PARA RETORNAR SUCESSO, O ARRAY ERROS DEVE ESTAR VAZIO, COMO VEJOS ABAIXO
    // CASO TENHA ERRO A PROPRIA FUNÇÃO COM SUAS VERIFICAÇÕES ADICIONA UMA MENSAGEM DE ERRO A ESSE ARRAY DE ERROS
    // PORTANTO ESSA LINHA NÃO É NECESSÁRIA

    if (empty($erros)) {
        return ['status' => 'sucesso'];
    } else {
        return ['status' => 'erro', 'mensagens' => $erros];
    }
}

/**
 * Busca produtos por nome, categoria ou ID.
 * @param string $termo Termo de busca.
 * @param string $tipo Tipo de busca ('nome', 'categoria', 'id').
 * @return array Lista de produtos encontrados.
 */
function buscar_produtos($termo, $tipo = 'nome') {
    $resultados = [];
    foreach ($GLOBALS['produtos'] as $produto) {
        if ($tipo === 'nome' && stripos($produto['nome'], $termo) !== false) {
            $resultados[] = $produto; // LINHA ADICIONADA, ESSE IF TAVA CHECANDO UMA CONDIÇÃO, PORÉM NÃO FAZIA NADA COM ISSO
        } elseif ($tipo === 'categoria' && stripos($produto['categoria'], $termo) !== false) {
            $resultados[] = $produto;
        } elseif ($tipo == 'id' && $produto['id'] == $termo) { // BUG RESOLVIDO, APENAS DOIS == NECESSARIOS, NÃO CHECAR O TIPO DE DADO
            $resultados[] = $produto;
        }
    }
    return $resultados;
}

/**
 * Atualiza o estoque de um produto.
 * @param int $produto_id ID do produto.
 * @param int $quantidade Quantidade para decrementar (negativo) ou incrementar (positivo).
 * @return array Status da operação (sucesso/erro) e mensagem.
 */
function atualizar_estoque($produto_id, $quantidade) {
    if (!isset($GLOBALS['produtos'][$produto_id])) {
        return ['status' => 'erro', 'mensagem' => 'Produto não encontrado.'];
    }

    $produto = &$GLOBALS['produtos'][$produto_id];

    $novo_estoque = $produto['estoque'] + $quantidade;

    if ($novo_estoque < 0) {
        return ['status' => 'erro', 'mensagem' => 'Estoque insuficiente para esta operação.'];
    }

    $produto['estoque'] = $novo_estoque;
    return ['status' => 'sucesso', 'mensagem' => 'Estoque atualizado com sucesso.'];
}
?>