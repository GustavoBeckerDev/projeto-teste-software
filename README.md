# Testes de Software para o Sistema "Moda Essencial"

Este repositório é dedicado aos testes de unidade e validação de um sistema de gerenciamento de vendas e estoque para a loja de vestuário "Moda Essencial". O objetivo principal é garantir a qualidade, a funcionalidade e a robustez de cada componente do sistema, simulando cenários reais de uso para identificar e corrigir possíveis falhas.

O sistema base, que está sendo testado, foi desenvolvido em PHP para otimizar as operações diárias da loja, que incluem controle de produtos, carrinho de compras, gerenciamento de pedidos e simulação de pagamentos. Este projeto de testes reflete a importância de uma validação rigorosa no processo de desenvolvimento de software.

>>> O Contexto do Projeto "Moda Essencial"

A "Moda Essencial", uma loja de vestuário em Videira, Santa Catarina, estava crescendo, mas enfrentava desafios com processos manuais de estoque e vendas. Esse cenário gerava confusão, perda de vendas e ineficiência. Para resolver isso, foi proposto o desenvolvimento de um sistema PHP que centralizasse e otimizasse as operações. Este repositório foca na etapa crucial de testar esse sistema.

>>> Funcionalidades do Sistema Testado

O sistema sob teste abrange as seguintes áreas, que são cobertas por nossos casos de teste:

* Controle de Produtos e Catálogo: Gerenciamento de informações como nome, preço, descrição, categoria e estoque. Inclui validação de dados de entrada, busca rápida de produtos e atualização de estoque.
* Carrinho de Compras: Permite adicionar, remover e ajustar quantidades de produtos, além de calcular o valor total da compra.
* Gerenciamento de Pedidos: Criação de pedidos detalhados com todos os itens, valor total e status (pendente, processando, enviado, entregue, cancelado), com a capacidade de atualizar esse status ao longo do processo logístico.
* Processamento de Pagamento (Simulado): Funcionalidade para simular transações de pagamento para completar o fluxo de compra.
* Utilitários Essenciais: Funções auxiliares, como formatação de preços para o padrão da moeda brasileira (R$).

>>> Estrutura do Projeto de Testes

O projeto de testes segue uma abordagem modular, com arquivos PHP dedicados a cada funcionalidade do sistema e seus respectivos testes.

* `config.php`: Para gerenciar as variáveis globais do sistema e dados "mock" que simulavam o banco de dados.
* `produtos_catalogo.php`: Contém as funções do módulo de Produtos e Catálogo (validar_produto, buscar_produtos e atualizar_estoque).
* `carrinho_compras.php`: Contém as funções do módulo de Carrinho de Compras (adicionar_item_carrinho, remover_item_carrinho, atualizar_quantidade_item_carrinho e calcular_total_carrinho).
* `pedidos.php`: Contém as funções do módulo de Pedidos (criar_pedido e atualizar_status_pedido).
* `processamento_pagamento.php`: Contendo a função processar_pagamento_externo, para simular transações.
* `auxiliares_utilitarios.php`: Para funções de apoio, como formatar_preco_brl.
* `modulo01.php`, `modulo02.php`, `modulo03.php`: Contêm os casos de teste específicos para cada módulo principal do sistema (Produtos, Carrinho, Pedidos, respectivamente).
* `runTests.php`: O script principal para executar todos os testes automatizados.

>>> Como Rodar os Testes

Para executar os testes deste projeto, você precisará de um ambiente com PHP instalado.

1. Pré-requisitos:
    Certifique-se de ter o PHP 🐘 instalado em sua máquina.

2. Clone o Repositório:
    Abra seu terminal ou prompt de comando e clone este repositório:
    ```bash
    git clone [https://github.com/seu-usuario/testes-de-software.git](https://github.com/seu-usuario/testes-de-software.git)
    cd testes-de-software
    ```

3. Executar os Testes:
    Com o PHP instalado e estando dentro da pasta raiz do projeto, execute o script `runTests.php`:
    ```bash
    php runTests.php
    ```
    O terminal exibirá o resultado da execução de cada teste, indicando se passou ou falhou.

>>> Relatório de Testes e Cobertura

Um relatório detalhado da execução dos testes foi gerado em 28 de junho de 2025 pelo testador Gustavo Becker.

* Total de testes executados: 20
* Total de testes no escopo: 26
* Testes que passaram: 20
* Testes que falharam: 00
* Cobertura estimada: 76.92%

Os testes abrangeram os módulos de Produtos e Catálogo, Carrinho de Compras e Pedidos.

>>> Bugs Encontrados e Corrigidos Durante os Testes

Durante a fase de testes, diversos problemas foram identificados e solucionados, garantindo a robustez das funcionalidades:

* Módulo 1: Produtos e Catálogo
    * PROD-001: Erro corrigido comentando a linha "$erros[ ] = “ERRO EXPLÍCITO DE VALIDAÇÃO”;" e adicionando um TRIM para evitar nomes com espaços vazios.
    * PROD-005 e PROD-006: Erro resolvido ao adicionar a linha `$resultados[]=$produto` que estava faltando no `if` do `foreach` na função `buscar_produtos`.
    * PROD-007: Erro resolvido na linha 54 do arquivo `produtos_catalogo.php`, usando apenas dois `==` para não checar o tipo de dado, permitindo que o ID seja passado como `int` ou `string`.

* Módulo 2: Carrinho de Compras
    * CARR-001: Erros corrigidos no arquivo `carrinho_compras.php`, resolvendo a duplicação desnecessária do item e adicionando `nome` e `preço` ao carrinho.

* Módulo 3: Pedidos
    * PED-001: Erro encontrado, a função `criar_pedido` não existia e havia uma função duplicada do arquivo `carrinho_compras.php`. Após a correção, a função `criar_pedido` foi criada e o teste foi concluído com sucesso, garantindo que o carrinho ficasse vazio após a criação do pedido.
    * PED-005: Erro corrigido na transição de status de `enviado` para `processando`. O erro acontecia porque não se pode mudar o status do produto depois de entregue. Uma alteração foi adicionada na lógica de transição para permitir o status `cancelado` após `enviado`.

>>> Contribuições

Este projeto é um exemplo prático da aplicação de testes de software em um contexto de desenvolvimento PHP. Sinta-se à vontade para explorar o código, sugerir melhorias ou reportar problemas. Toda contribuição é bem-vinda!
