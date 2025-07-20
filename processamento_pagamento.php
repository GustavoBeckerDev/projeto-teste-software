<?php
// processamento_pagamento.php

require_once __DIR__ . '/config.php'; // Inclui as variáveis globais

/**
 * Simula o processamento de um pagamento externo.
 * @param float $valor Valor do pagamento.
 * @param array $dados_cartao Dados simulados do cartão (ex: 'numero', 'cvv', 'validade').
 * @return array Status do pagamento (sucesso/recusado/erro) e mensagem.
 */
function processar_pagamento_externo($valor, $dados_cartao) {
    // --- Mock: Simulação de gateway de pagamento ---

    if (!is_numeric($valor) || $valor < 0) {
        return ['status' => 'erro', 'mensagem' => 'Valor do pagamento inválido.'];
    }

    // Simulação de cartão inválido (número termina em 000)
    if (isset($dados_cartao['numero']) && substr($dados_cartao['numero'], -3) === '000') {
        return ['status' => 'recusado', 'mensagem' => 'Cartão inválido.'];
    }

    // Simulação de saldo insuficiente (número termina em 111)
    if (isset($dados_cartao['numero']) && substr($dados_cartao['numero'], -3) === '111') {
        return ['status' => 'recusado', 'mensagem' => 'Saldo insuficiente.'];
    }

    // Simulação de erro de comunicação com o gateway (número termina em 999)
    if (isset($dados_cartao['numero']) && substr($dados_cartao['numero'], -3) === '998') { 
        return ['status' => 'erro', 'mensagem' => 'Erro na comunicação com o gateway de pagamento. Tente novamente mais tarde.'];
    }

    // Pagamento bem-sucedido
    return ['status' => 'sucesso', 'mensagem' => 'Pagamento processado com sucesso.'];
}
?>