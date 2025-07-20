<?php

require_once 'modulo01.php';
require_once 'modulo02.php';
require_once 'modulo03.php';

echo "\n";
echo "========== CASOS DE TESTE DA LOJA DE VESTUÁRIO MODA ESSENCIAL ========== \n";
echo "\n";
echo "==================== Módulo 1: Produtos e Catálogo ===================== \n";
echo "\n";
assert(validarProdutoValido()); // OK
assert(validarProdutoNomeVazio()); // OK
assert(validarProdutoPrecoNegativo()); // OK
assert(validarProdutoEstoqueNaoNumerico()); // OK
assert(testarBuscaPorNome()); // OK
assert(testarBuscaPorCategoria()); // OK
assert(testarBuscaPorId()); // OK
assert(testarAtualizarEstoqueDecremento()); // OK
assert(testarAtualizacaoEstoqueInsuficiente()); // OK 
echo "\n";
echo "==================== Módulo 2: Carrinho de Compras ===================== \n";
echo "\n";
assert(testeAdicionarNovoItemCarrinho()); // OK
assert(testeAdicionarItemExistenteCarrinho()); // OK
assert(testarRemoverItemCarrinho()); // OK
assert(testarAtualizarQuantidadeItemCarrinho()); // OK
assert(testarAtualizarQuantidadeParaZero()); // OK
assert(testarCalcularTotalCarrinho()); // OK
echo "\n";
echo "==================== Módulo 3: Pedidos ===================== \n";

//assert(testarCriacaoPedidoCarrinhoValido()); // OK
//assert(testarCriacaoPedidoCarrinhoVazio()); // OK
//assert(testarCriacaoPedidoProdutoInexistente()); // OK
assert(testarAtualizacaoStatusPedidoTransicaoValida()); // PARA RODAR O TESTE DESSAS LINHAS, SE DEVE COMENTAR AS 3 PRIMEIRAS DO MÓDULO 3
assert(testarAtualizacaoStatusPedidoTransicaoInvalida()); // PARA RODAR O TESTE DESSAS LINHAS, SE DEVE COMENTAR AS 3 PRIMEIRAS DO MÓDULO 3

// OS COMENTÁRIOS SÃO NECESSÁRIOS PORQUE AS 3 PRIMEIRAS LINHAS AFETAM DIRETAMENTE AS 2 ÚLTIMOS DESTE MÓDULO.
// PARA RODAR O TESTE DAS 2 ÚLTIMAS LINHAS, SE DEVE COMENTAR AS 3 PRIMEIRAS DO MÓDULO 3
// OPÇÃO POSSÍVEL, ZERAR AS VARIÁVEIS GLOBAIS COMO CARRINHO, PEDIDOS E NEXT_PEDIDO_ID PARA NÃO AFETAR

?>