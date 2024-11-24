# Documentação do Banco de Dados "NOPRECINHODB"

**Data:** 24/11/2024  
**Autor:** Pedro Castilhos  

---

## 1ª Tabela: Produto

- **Objetivo:** Armazenar informações sobre os produtos disponíveis.
- **Campos:**
  - `UUID`: Identificador único do produto (chave primária).
  - `CODIGO`: Código identificador do produto.
  - `NOME`: Nome do produto.
  - `MARCA`: Marca do produto (NULLABLE).
- **Relacionamentos:**  
  A tabela Produto não é dependente de nenhuma outra, mas outras três tabelas se relacionam com ela:  
  - `ItemNotaFiscal`
  - `ItensListaGerada`
  - `Lista`

  Todas essas tabelas fazem relacionamento com o campo `UUID` de Produto.

---

## 2ª Tabela: Usuario

- **Objetivo:** Registrar informações dos usuários do sistema.
- **Campos:**
  - `UUID`: Identificador único do usuário (chave primária).
  - `NOME`: Nome do usuário.
  - `CIDADE`: Cidade onde o usuário reside.
  - `ESTADO`: Estado onde o usuário reside.
  - `TEM_CARRO`: Indica se o usuário possui carro (booleano).
  - `KM_POR_LITRO`: Eficiência do carro do usuário (km por litro), relevante para calcular custos de transporte.
  - `CREDITOS`: Créditos disponíveis para o usuário no sistema.
- **Relacionamentos:**  
  A tabela Usuario não é dependente de nenhuma outra, mas outras três tabelas se relacionam com ela:  
  - `NotaFiscal`
  - `ListaGerada`
  - `Lista`

  Todas essas tabelas fazem relacionamento com o campo `UUID` de Usuario.

---

## 3ª Tabela: Estabelecimento

- **Objetivo:** Armazenar informações sobre os estabelecimentos que emitem notas fiscais ou participam de listas de compras.
- **Campos:**
  - `UUID`: Identificador único do estabelecimento (chave primária).
  - `CNPJ`: Cadastro Nacional da Pessoa Jurídica, único por estabelecimento.
  - `RAZAO_SOCIAL`: Nome formal do estabelecimento.
  - `ENDERECO`: Endereço do estabelecimento.
  - `CIDADE`: Cidade onde o estabelecimento está localizado.
  - `ESTADO`: Estado onde o estabelecimento está localizado.
- **Relacionamentos:**  
  A tabela Estabelecimento não é dependente de nenhuma outra, mas outras duas tabelas se relacionam com ela:  
  - `NotaFiscal`
  - `ListaGerada`

  Ambas fazem relacionamento com o campo `UUID` de Estabelecimento.

---

## 4ª Tabela: NotaFiscal

- **Objetivo:** Registrar informações das notas fiscais emitidas.
- **Campos:**
  - `UUID`: Identificador único da nota fiscal (chave primária).
  - `IDUSUARIO`: Referência ao usuário (chave estrangeira de Usuario).
  - `IDESTABELECIMENTO`: Referência ao estabelecimento (chave estrangeira de Estabelecimento).
  - `DATAEMISSAO`: Data e hora da emissão da nota fiscal.
  - `VALORTOTAL`: Valor total da nota fiscal.
- **Relacionamentos:**
  - `UUID` relaciona com `IDNOTAFISCAL` de `ItemNotaFiscal`.
  - `IDUSUARIO` relaciona com `UUID` de `Usuario`.
  - `IDESTABELECIMENTO` relaciona com `UUID` de `Estabelecimento`.

---

## 5ª Tabela: ItemNotaFiscal

- **Objetivo:** Detalhar os itens comprados em uma nota fiscal.
- **Campos:**
  - `UUID`: Identificador único do item (chave primária).
  - `IDNOTAFISCAL`: Referência à nota fiscal (chave estrangeira de NotaFiscal).
  - `IDPRODUTO`: Referência ao produto (chave estrangeira de Produto).
  - `QUANTIDADE`: Quantidade do produto adquirido.
  - `VALORUNITARIO`: Valor unitário do produto.
  - `VALORTOTAL`: Valor total do item (`QUANTIDADE × VALORUNITARIO`).
- **Relacionamentos:**
  - `IDNOTAFISCAL` relaciona com `UUID` de `NotaFiscal`.
  - `IDPRODUTO` relaciona com `UUID` de `Produto`.

---

## 6ª Tabela: Lista

- **Objetivo:** Registrar listas de produtos criadas pelos usuários.
- **Campos:**
  - `UUID`: Identificador único da lista (chave primária).
  - `IDPRODUTO`: Referência ao produto (chave estrangeira de Produto).
  - `IDUSUARIO`: Referência ao usuário que criou a lista (chave estrangeira de Usuario).
  - `QUANTIDADE`: Quantidade desejada do produto.
- **Relacionamentos:**
  - `IDPRODUTO` relaciona com `UUID` de `Produto`.
  - `IDUSUARIO` relaciona com `UUID` de `Usuario`.

---

## 7ª Tabela: ListaGerada

- **Objetivo:** Registrar listas de compras geradas com base em dados de mercado e locais.
- **Campos:**
  - `UUID`: Identificador único da lista gerada (chave primária).
  - `IDUSUARIO`: Referência ao usuário (chave estrangeira de Usuario).
  - `IDESTABELECIMENTO`: Referência ao estabelecimento onde a lista foi gerada (chave estrangeira de Estabelecimento).
  - `DATAHORA`: Data e hora da geração da lista.
- **Relacionamentos:**
  - `IDUSUARIO` relaciona com `UUID` de `Usuario`.
  - `IDESTABELECIMENTO` relaciona com `UUID` de `Estabelecimento`.

---

## 8ª Tabela: ItensListaGerada

- **Objetivo:** Detalhar os itens de uma lista gerada.
- **Campos:**
  - `UUID`: Identificador único do item (chave primária).
  - `IDLISTAGERADA`: Referência à lista gerada (chave estrangeira de ListaGerada).
  - `IDPRODUTO`: Referência ao produto (chave estrangeira de Produto).
  - `PRECO`: Preço do produto no estabelecimento.
  - `MEDIAMERCADO`: Média de preços do produto no mercado.
  - `QUANTIDADE`: Quantidade do produto na lista.
- **Relacionamentos:**
  - `IDLISTAGERADA` relaciona com `UUID` de `ListaGerada`.
  - `IDPRODUTO` relaciona com `UUID` de `Produto`.

---

## Explicação dos Relacionamentos

### 1. Produto
- **Relacionamentos com:**
  - `ItemNotaFiscal`: Identifica o produto adquirido em uma transação registrada em nota fiscal.
  - `ItensListaGerada`: Associa produtos às listas geradas automaticamente.
  - `Lista`: Relaciona produtos aos itens desejados pelos usuários.

**Propósito Geral:** Permitir que os produtos sejam referenciados em diversos contextos, como vendas e planejamento.

### 2. Usuario
- **Relacionamentos com:**
  - `NotaFiscal`: Conecta transações ao histórico de consumo dos usuários.
  - `Lista`: Associa listas manuais aos usuários.
  - `ListaGerada`: Permite listas personalizadas geradas automaticamente.

**Propósito Geral:** Associar preferências e comportamentos a cada usuário.

### 3. Estabelecimento
- **Relacionamentos com:**
  - `NotaFiscal`: Identifica onde transações ocorreram.
  - `ListaGerada`: Relaciona listas a locais de compra.

**Propósito Geral:** Mapear estabelecimentos e monitorar transações e preços.

### 4. NotaFiscal
- **Relacionamentos com:**
  - `Usuario`: Conecta compradores às transações.
  - `Estabelecimento`: Identifica locais de emissão.
  - `ItemNotaFiscal`: Detalha os itens adquiridos.

**Propósito Geral:** Registrar transações completas.

### 5. ItemNotaFiscal
- **Relacionamentos com:**
  - `NotaFiscal`: Detalha itens em uma transação.
  - `Produto`: Relaciona itens vendidos ao catálogo de produtos.

**Propósito Geral:** Detalhar itens comprados.

### 6. Lista
- **Relacionamentos com:**
  - `Produto`: Registra produtos planejados.
  - `Usuario`: Conecta listas aos usuários.

**Propósito Geral:** Registrar listas manuais.

### 7. ListaGerada
- **Relacionamentos com:**
  - `Usuario`: Personaliza listas geradas.
  - `Estabelecimento`: Relaciona listas a locais de compra.

**Propósito Geral:** Gerar listas automáticas ajustadas.

### 8. ItensListaGerada
- **Relacionamentos com:**
  - `ListaGerada`: Detalha os itens de uma lista.
  - `Produto`: Relaciona preços e quantidades ao catálogo.

**Propósito Geral:** Detalhar itens em listas geradas.
