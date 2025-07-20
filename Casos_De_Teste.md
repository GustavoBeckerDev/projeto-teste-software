
Módulo 1: Produtos e Catálogo (produtos\_catalogo.php) 

------------------------------------  TESTE 01 VALIDAÇÃO DE PRODUTO COM TUDO CORRETO ---------------------------------------

**Teste ID: PROD-001 - Validação de Produto Válido**

**Objetivo:** Verificar se um produto com dados corretos é validado com sucesso. 
**Pré-condições:** Nenhuma. 
**Passos:**
* Chamar validar\_produto('Camisa Polo', 120.00, 'Camisa de algodão, tamanho M', 30). 
**Resultados**
* A função deve retornar \['status' => 'sucesso'\]. 

------------------------------------- TESTE 02 VALIDAÇÃO DE PRODUTO COM NOME VAZIO ------------------------------------------

**Teste ID: PROD-002 - Validação de Produto com Nome Vazio** 
**Objetivo:** Verificar a validação de um produto com nome vazio. 
**Pré-condições:** Nenhuma. 
**Passos:**
*   Chamar validar\_produto('', 50.00, 'Vestido de verão', 10). 
**Resultados **
*   A função deve retornar \['status' => 'erro'\]. 
*   As mensagens de erro devem incluir "Nome do produto não pode ser vazio.".

------------------------------------- TESTE 03 VALIDAÇÃO DE PRODUTO COM PREÇO NEGATIVO ----------------------------------------

**Teste ID: PROD-003 - Validação de Produto com Preço Negativo**
**Objetivo:** Verificar a validação de um produto com preço negativo. 
**Pré-condições:** Nenhuma. 
**Passos:**
* Chamar validar\_produto('Meia Esportiva', -10.00, 'Par de meias', 100).
**Resultados:**  
* A função deve retornar \['status' => 'erro'\]. 
* As mensagens de erro devem incluir "Preço deve ser um número positivo.". 

------------------------------------- TESTE 04 VALIDAÇÃO DE PRODUTO COM ESTOQUE NÃO NUMÉRICO ----------------------------------------

**Teste ID: PROD-004 - Validação de Produto com Estoque Não Numérico**

**Objetivo:**** Verificar a validação de um produto com estoque não numérico. 
**Pré-condições:** Nenhuma. 
**Passos:**  
* Chamar validar\_produto('Cinto de Couro', 75.00, 'Cinto marrom', 'vinte').
**Resultados**  
*A função deve retornar \['status' => 'erro'\]. 
*As mensagens de erro devem incluir "Estoque deve ser um número inteiro não negativo.". 

------------------------------------- TESTE 05 BUSCA DE PRODUTO POR NOME ----------------------------------------

**Teste ID: PROD-005 - Busca de Produto por Nome**

**Objetivo:** Verificar se a busca de produtos por nome retorna resultados esperados. 
**Pré-condições:** Produtos mock carregados. 
**Passos:** 
* Chamar buscar\_produtos('Camiseta', 'nome'). 
**Resultados**  
* A função deve retornar um array contendo o produto 'Camiseta'. 

------------------------------------- TESTE 06 BUSCA DE PRODUTO POR CATEGORIA ----------------------------------------

**Teste ID: PROD-006 - Busca de Produto por Categoria**

**Objetivo:** Verificar se a busca de produtos por categoria funciona corretamente. 
**Pré-condições:** Produtos mock carregados. 
**Passos:**
* Chamar buscar\_produtos('Roupas', 'categoria'). 
**Resultados**  
* A função deve retornar um array contendo os produtos 'Camiseta' e 'Calça Jeans'. 

------------------------------------- TESTE 07 BUSCA DE PRODUTO POR ID ----------------------------------------

**Teste ID: PROD-007 - Busca de Produto por ID (String e Int)**

**Objetivo:** Verificar se a busca de produtos por ID funciona corretamente, independentemente do tipo de dado (string ou inteiro). 
**Pré-condições:** Produtos mock carregados. 
**Passos:**  
* Chamar buscar\_produtos(2, 'id') (passando ID como inteiro). 
* Chamar buscar\_produtos('2', 'id') (passando ID como string). 
**Resultados**  
* Para o passo 1: A função deve retornar um array contendo a 'Calça Jeans'. 
* Para o passo 2: A função deve retornar um array contendo a 'Calça Jeans'. 
  
------------------------------------- TESTE 08 ATUALIZAÇÃO DE ESTOQUE ----------------------------------------

**Teste ID: PROD-008 - Atualização de Estoque - Decremento**

**Objetivo:** Verificar o decremento de estoque quando há quantidade suficiente. 
**Pré-condições:** 
*Produto 'Camiseta' (ID 1) com estoque inicial de 50. 

**Passos:**  
* Chamar atualizar\_estoque(1, -10). 
**Resultados**  
* A função deve retornar \['status' => 'sucesso'\]. 
* O estoque da 'Camiseta' deve ser atualizado para 40. 

------------------------------------- TESTE 09 ATUALIZAÇÃO DE ESTOQUE ----------------------------------------


**Teste ID: PROD-009 - Atualização de Estoque - Insuficiente**

**Objetivo:** Verificar se a atualização de estoque impede operações com quantidade insuficiente. 
**Pré-condições:** Produto 'Tênis Esportivo' (ID 3) com estoque inicial de 20. 
**Passos:**  
* Chamar atualizar\_estoque(3, -25). 
**Resultados**  
* A função deve retornar \['status' => 'erro', 'mensagem' => 'Estoque insuficiente para esta operação.'\]. 
* O estoque do 'Tênis Esportivo' deve permanecer 20. 

---------------------------------- MÓDULO DOIS : CARRINHO DE COMPRAS ---------------------------------------

**Módulo 2: Carrinho de Compras (carrinho\_compras.php)**

------------------------------------- TESTE 01 : ADICIONAR NOVO ITEM AO CARRINHO ----------------------------------

**Teste ID: CARR-001 - Adicionar Novo Item ao Carrinho** 

**Objetivo:** Verificar se um novo item é adicionado corretamente ao carrinho com a quantidade e informações corretas. 
**Pré-condições:** Carrinho vazio. 
**Passos:**  
* Chamar adicionar\_item\_carrinho(1, 2) (adicionar 2 camisetas). 

**Resultados**  

* A função deve retornar \['status' => 'sucesso'\]. 

* O carrinho deve conter o produto\_id 1. 

* A quantidade do produto 1 no carrinho deve ser 2. 

* O item no carrinho deve conter as chaves 'nome' e 'preco' com os valores corretos do produto. 

--------------------------------- TESTE 02 : ADICIONAR MAIS UNIDADES DE ITEM EXISTENTE ---------------------------------------

**Teste ID: CARR-002 - Adicionar Mais Unidades de Item Existente** 

**Objetivo:** Verificar se a quantidade de um item existente no carrinho é atualizada corretamente. 

**Pré-condições:** Carrinho contendo 2 unidades da 'Camiseta' (ID 1) do teste CARR-001. 

**Passos:**  

* Chamar adicionar\_item\_carrinho(1, 3) (adicionar mais 3 camisetas). 

**Resultados**  

* A função deve retornar \['status' => 'sucesso'\]. 

* A quantidade total do produto 1 no carrinho deve ser 5. 

------------------------------------ TESTE 03 : REMOVER ITEM DO CARRINHO -----------------------------------------------------

**Teste ID: CARR-003 - Remover Item do Carrinho** 

**Objetivo:** Verificar se um item é removido com sucesso do carrinho. 

**Pré-condições:** Carrinho contendo o produto 'Calça Jeans' (ID 2). (Adicione com adicionar\_item\_carrinho(2, 1) antes deste teste). 

**Passos:**  

* Chamar remover\_item\_carrinho(2). 

**Resultados**  

* A função deve retornar \['status' => 'sucesso'\]. 

* O produto\_id 2 não deve mais existir no $GLOBALS\['carrinho'\]. 

------------------------------------ TESTE 04 : ATUALIZAR QUANTIDADE DE ITEM (DIMINUIR) ----------------------------------------

**Teste ID: CARR-004 - Atualizar Quantidade de Item (Diminuir)** 

**Objetivo:** Verificar a atualização da quantidade de um item existente para um valor menor. 

**Pré-condições:** Carrinho contendo 5 unidades da 'Camiseta' (ID 1). 

**Passos:**  

* Chamar atualizar\_quantidade\_item\_carrinho(1, 2). 

**Resultados**  

* A função deve retornar \['status' => 'sucesso'\]. 

* A quantidade do produto 1 no carrinho deve ser 2. 

------------------------------------- ATUALIZAR QUANTIDADE DE ITEM (PARA ZERO/REMOVER) -------------------------------------

**Teste ID: CARR-005 - Atualizar Quantidade de Item (Para Zero/Remover)** 

**Objetivo:** Verificar se atualizar a quantidade para zero ou menos remove o item do carrinho. 

**Pré-condições:** Carrinho contendo o produto 'Tênis Esportivo' (ID 3). (Adicione com adicionar\_item\_carrinho(3, 1) antes deste teste). 

**Passos:**  

* Chamar atualizar\_quantidade\_item\_carrinho(3, 0). 

**Resultados**  

* A função deve retornar \['status' => 'sucesso'\]. 

**O produto\_id 3 não deve mais existir no $GLOBALS\['carrinho'\]. 

-------------------------------------------------- CALCULAR TOTAL DO CARRINHO -------------------------------------------------

**Teste ID: CARR-006 - Calcular Total do Carrinho**

**Objetivo:** Verificar o cálculo do valor total do carrinho. 

**Pré-condições:**  

* Limpar o carrinho. 

* Adicionar adicionar\_item\_carrinho(1, 2) (2 Camisetas) 

* Adicionar adicionar\_item\_carrinho(2, 1) (1 Calça Jeans) 

* Adicionar adicionar\_item\_carrinho(3, 3) (3 Tênis) 

**Passos:**  

* Chamar calcular\_total\_carrinho(). 

**Resultados**  

* A função deve retornar o valor (29.90 \* 2) + (89.90 \* 1) + (150.00 \* 3) = 59.80 + 89.90 + 450.00 = 599.70. 

---------------------------------------------------- MÓDULO 03 PEDIDOS ---------------------------------------------------------------

Módulo 3: Pedidos (pedidos.php) 

**Teste ID: PED-001 - Criação de Pedido com Carrinho Válido** 

**Objetivo:** Verificar a criação de um pedido a partir de um carrinho válido. 

**Pré-condições:**  

* Limpar $GLOBALS\['carrinho'\]. 

* Adicionar itens ao carrinho: adicionar\_item\_carrinho(1, 1) (1 Camiseta), adicionar\_item\_carrinho(2, 1) (1 Calça Jeans). 

**Passos:**  

* Chamar criar\_pedido($GLOBALS\['carrinho'\]). 

**Resultados**  

* A função deve retornar \['status' => 'sucesso'\] e conter um array pedido. 

* O estoque dos produtos envolvidos deve ser decrementado corretamente (ex: Camiseta e Calça Jeans terão seus estoques reduzidos em 1 unidade cada). 

* O $GLOBALS\['carrinho'\] deve estar vazio após a criação do pedido. 

* O status do pedido criado deve ser 'pendente'. 

-----------------------------------------------------------------------------------------------------------

**Teste ID: PED-002 - Criação de Pedido com Carrinho Vazio**

**Objetivo:** Verificar o comportamento ao tentar criar um pedido com um carrinho vazio. 

**Pré-condições:** $GLOBALS\['carrinho'\] está vazio. 

**Passos:**  

* Chamar criar\_pedido($GLOBALS\['carrinho'\]). 

**Resultados**  

* A função deve retornar \['status' => 'erro', 'mensagem' => 'Carrinho de compras vazio. Não é possível criar um pedido.'\]. 

---------------------------------------------------------------------------------------------------------------------

Teste ID: PED-003 - Criação de Pedido com Produto Inexistente no Catálogo 

**Objetivo:** Verificar o comportamento ao tentar criar um pedido com um produto que não existe no catálogo. 

**Pré-condições:**  

**Limpar $GLOBALS\['carrinho'\]. 

* Adicionar um item com ID 99 (produto inexistente) ao carrinho: $GLOBALS\['carrinho'\]\[99\] = \['id' => 99, 'nome' => 'Item Inexistente', 'preco' => 10.00, 'quantidade' => 1\];. 

**Passos:**  

* Chamar criar\_pedido($GLOBALS\['carrinho'\]). 

**Resultados**  

* A função deve retornar \['status' => 'erro', 'mensagem' => 'Produto não existe no catálogo: ID 99'\] (ou similar, indicando que o produto não foi encontrado antes de tentar acessar seu estoque). 

------------------------------------------------------------------------------------------------------------------------------

**Teste ID: PED-004 - Atualização de Status de Pedido - Transição Válida** 

**Objetivo:** Verificar se o status de um pedido é atualizado corretamente de 'pendente' para 'processando'. 

**Pré-condições:** Um pedido existente com status 'pendente'. 

**Passos:**  

* Obtenha o ID de um pedido recém-criado. 

* Chamar atualizar\_status\_pedido(ID\_DO\_PEDIDO, 'processando'). 

**Resultados**  

* A função deve retornar \['status' => 'sucesso'\]. 

* O status do pedido no $GLOBALS\['pedidos'\] deve ser 'processando'. 

-------------------------------------------------------------------------------------------------------------------------------

**Teste ID: PED-005 - Atualização de Status de Pedido - Transição Inválida Negada** 

**Objetivo:** Verificar se o sistema nega transições de status que são logicamente inválidas (ex: 'entregue' para 'processando'). 

**Pré-condições:** Um pedido existente. 

**Passos:**  

* Atualize o status do pedido para 'enviado'. 

* Atualize o status do pedido para 'entregue'. 

* Chamar atualizar\_status\_pedido(ID\_DO\_PEDIDO, 'processando'). 

**Resultados**  

* A função deve retornar \['status' => 'erro'\]. 

* A mensagem de erro deve indicar uma "Transição de status inválida" de 'entregue' para 'processando'. 

* O status do pedido não deve ser alterado e permanecer 'entregue'. 

--------------------------------------------- MÓDULO 04 PROCESSAMENTO DE PAGAMENTO ----------------------------------------------

**Módulo 4: Processamento de Pagamento (processamento\_pagamento.php)** 

**Teste ID: PGTO-001 - Processar Pagamento Válido** 

**Objetivo:** Verificar o processamento de um pagamento com dados válidos. 

**Pré-condições:** Nenhuma. 

**Passos:**  

* Chamar processar\_pagamento\_externo(150.00, \['numero' => '1234567890123456', 'cvv' => '123', 'validade' => '12/25'\]). 

**Resultados**  

* A função deve retornar \['status' => 'sucesso', 'mensagem' => 'Pagamento processado com sucesso.'\]. 

------------------------------------ TESTE 02 PROCESSAR PAGAMENTO COM VALOR ZERO OU NEGATIVO ------------------------------------

**Teste ID: PGTO-002 - Processar Pagamento com Valor Zero ou Negativo**

**Objetivo:** Verificar o comportamento ao tentar processar um pagamento com valor zero ou negativo. 

**Pré-condições:** Nenhuma. 

**Passos:**  

* Chamar processar\_pagamento\_externo(0.00, \['numero' => '1234567890123456', 'cvv' => '123', 'validade' => '12/25'\]). 

* Chamar processar\_pagamento\_externo(-10.00, \['numero' => '1234567890123456', 'cvv' => '123', 'validade' => '12/25'\]). 

**Resultados**  

**Para ambos os Passos:** 
* A função deve retornar \['status' => 'erro', 'mensagem' => 'Valor do pagamento inválido.'\]. 

**Teste ID: PGTO-003 - Processar Pagamento - Cartão Inválido**

**Objetivo:** Verificar a recusa de pagamento para um cartão explicitamente inválido (simulação). 

**Pré-condições:** Nenhuma. 

**Passos:**  

* Chamar processar\_pagamento\_externo(100.00, \['numero' => '1234567890123000', 'cvv' => '123', 'validade' => '12/25'\]). 

**Resultados**  

* A função deve retornar \['status' => 'recusado', 'mensagem' => 'Cartão inválido.'\]. 

**Teste ID: PGTO-004 - Processar Pagamento - Saldo Insuficiente** 

**Objetivo:** Verificar a recusa de pagamento por saldo insuficiente (simulação). 

**Pré-condições:** Nenhuma. 

**Passos:**  

* Chamar processar\_pagamento\_externo(200.00, \['numero' => '1234567890123111', 'cvv' => '123', 'validade' => '12/25'\]). 

**Resultados**  

* A função deve retornar \['status' => 'recusado', 'mensagem' => 'Saldo insuficiente.'\]. 

----------------------------------------------------------------------------------------------------

**Módulo 5: Funções Auxiliares e Utilitários (auxiliares\_utilitarios.php)**

****Teste ID: AUX-001 - Formatação de Preço - Decimal** 

**Objetivo:** Verificar a formatação de valores decimais para o padrão BRL. 

**Pré-condições:** Nenhuma. 

**Passos:**  

* Chamar formatar\_preco\_brl(1234.56). 

**Resultados**  

* A função deve retornar a string 'R$ 1.234,56'. 

**Teste ID: AUX-002 - Formatação de Preço - Inteiro** 

**Objetivo:** Verificar a formatação de valores inteiros (com zeros decimais) para o padrão BRL. 

* Pré-condições:** Nenhuma. 
**Passos:**  

* Chamar formatar\_preco\_brl(100.00). 

* Chamar formatar\_preco\_brl(50). 

**Resultados**  

* Para o passo 1: A função deve retornar a string 'R$ 100,00'. 

* Para o passo 2: A função deve retornar a string 'R$ 50,00'. 
