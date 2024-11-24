SELECT 
    u."nome" AS Usuario,
        SUM(nf."valorTotal") AS TotalGasto
        FROM 
            "NotaFiscal" nf
            JOIN 
                "Usuario" u ON nf."usuarioId" = u."usuarioId"
                GROUP BY 
                    u."nome"
                    ORDER BY 
                        TotalGasto DESC

-----------------

SELECT 
    u.NOME AS Usuario,
    SUM(nf.VALORTOTAL) AS TotalGasto
FROM 
    NotaFiscal nf
JOIN 
    Usuario u ON nf.IDUSUARIO = u.UUID
GROUP BY 
    u.NOME
ORDER BY 
    TotalGasto DESC;
