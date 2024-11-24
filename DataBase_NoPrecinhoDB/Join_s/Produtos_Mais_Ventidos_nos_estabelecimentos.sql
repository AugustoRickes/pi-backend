SELECT 
    e."razaoSocial" AS Estabelecimento,
        p.nome AS Produto,
            SUM(inf.quantidade) AS TotalVendido
            FROM 
                "ItemNotaFiscal" inf
                JOIN 
                    "Produto" p ON inf."produtoId" = p."produtoId"
                    JOIN 
                        "NotaFiscal" nf ON inf."notaFiscalId" = nf."notaFiscalId"
                        JOIN 
                            "Estabelecimento" e ON nf."estabelecimentoId" = e."estabelecimentoId"
                            GROUP BY 
                                e."razaoSocial", p.nome
                                ORDER BY 
                                    e."razaoSocial", TotalVendido DESC

--------------------

SELECT 
    e.RAZAO_SOCIAL AS Estabelecimento,
    p.NOME AS Produto,
    SUM(inf.QUANTIDADE) AS TotalVendido
FROM 
    ItemNotaFiscal inf
JOIN 
    Produto p ON inf.IDPRODUTO = p.UUID
JOIN 
    NotaFiscal nf ON inf.IDNOTAFISCAL = nf.UUID
JOIN 
    Estabelecimento e ON nf.IDESTABELECIMENTO = e.UUID
GROUP BY 
    e.RAZAO_SOCIAL, p.NOME
ORDER BY 
    e.RAZAO_SOCIAL, TotalVendido DESC;
