<?php
// auxiliares_utilitarios.php
// Este módulo geralmente não precisa incluir config.php se as funções forem puramente utilitárias
// e não dependam de dados globais (o que é o caso aqui).

/**
 * Formata um número para o formato de moeda brasileira (R$).
 * @param float $valor O valor a ser formatado.
 * @return string O valor formatado como moeda.
 */
function formatar_preco_brl($valor) {
    if ($valor == (int)$valor) { // Se for um número inteiro exato
        return 'R$ ' . number_format($valor, 1, ',', '.');
    }
    return 'R$ ' . number_format($valor, 2, ',', '.');
}
?>