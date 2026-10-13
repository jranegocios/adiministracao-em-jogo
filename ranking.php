
<?php
require_once "conexao.php";

try {
    // $sql = "SELECT
    //             nome,
    //             turma,
    //             SUM(pontos) AS total_pontos,
    //             SUM(acertos) AS total_acertos
    //         FROM pontuacoes
    //         GROUP BY nome, turma
    //         ORDER BY total_pontos DESC,
    //                  total_acertos DESC,
    //                  nome ASC
    //         LIMIT 10";

    
    $sql = "SELECT
            p.nome,
            p.turma,
            p.pontos AS total_pontos,
            p.acertos AS total_acertos
        FROM pontuacoes p
        WHERE NOT EXISTS (
            SELECT 1
            FROM pontuacoes p2
            WHERE p2.nome = p.nome
              AND p2.turma = p.turma
              AND (
                  p2.pontos > p.pontos
                  OR (
                      p2.pontos = p.pontos
                      AND p2.acertos > p.acertos
                  )
                  OR (
                      p2.pontos = p.pontos
                      AND p2.acertos = p.acertos
                      AND (
                          p2.data_jogo < p.data_jogo
                          OR (
                              p2.data_jogo = p.data_jogo
                              AND p2.id < p.id
                          )
                      )
                  )
              )
        )
        ORDER BY
            p.pontos DESC,
            p.acertos DESC,
            p.nome ASC
        LIMIT 10";

    
    $consulta = $conexao->query($sql);
    $ranking = $consulta->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    error_log($erro->getMessage());
    die("Não foi possível carregar o ranking.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking - Administração em Jogo</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f5f9;
            padding: 30px 15px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #172554;
            color: white;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background: #172554;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<main>
    <h1>🏆 Ranking Top 10</h1>
    <p>Os participantes com as maiores pontuações</p>

    <?php if (count($ranking) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Participante</th>
                    <th>Turma</th>
                    <th>Pontos</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($ranking as $indice => $participante): ?>
                    <tr>
                        <td><?= $indice + 1 ?>º</td>
                        <td>
                            <?= htmlspecialchars(
                                $participante["nome"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars(
                                $participante["turma"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </td>
                        <td>
                            <?= (int) $participante["total_pontos"] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p>Ainda não há pontuações registradas.</p>
    <?php endif; ?>

    <a href="index.php">Voltar ao início</a>
</main>

</body>
</html>
