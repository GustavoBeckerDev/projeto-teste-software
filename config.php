<?php
// config.php

// --- Dados Mock (simulando um banco de dados ou armazenamento) ---
// Estes dados são globais e acessíveis por todas as funções que os incluem
$GLOBALS['produtos'] = [
    1 => ['id' => 1, 'nome' => 'Camiseta', 'preco' => 29.90, 'descricao' => 'Camiseta de algodão', 'estoque' => 50, 'categoria' => 'Roupas'],
    2 => ['id' => 2, 'nome' => 'Calça Jeans', 'preco' => 89.90, 'descricao' => 'Calça jeans slim fit', 'estoque' => 30, 'categoria' => 'Roupas'],
    3 => ['id' => 3, 'nome' => 'Tênis Esportivo', 'preco' => 150.00, 'descricao' => 'Tênis para corrida', 'estoque' => 20, 'categoria' => 'Calçados'],
    4 => ['id' => 4, 'nome' => 'Boné', 'preco' => 25.00, 'descricao' => 'Boné unissex', 'estoque' => 10, 'categoria' => 'Acessórios'],
];

$GLOBALS['carrinho'] = [];
$GLOBALS['pedidos'] = [];
$GLOBALS['next_pedido_id'] = 1;
?>