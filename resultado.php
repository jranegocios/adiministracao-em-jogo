
<?php
session_start();
require_once "assuntos.php";
require_once "conexao.php";

if (
    !isset($_SESSION["participante"]) ||
    !isset($_SESSION["resultado_quiz"])
) {
    header("Location: index.php");
    exit;
}

$resultado = $_SESSION["resultado_quiz"];

// $nome = $_SESSION["participante"]["nome"];
// $assunto = $assuntos[$resultado["assunto_id"]];
// $pontos = $resultado["pontos"];
// $acertos = $resultado["acertos"];

if (
    !isset($resultado["id_rodada"]) ||
    !isset($resultado["assunto_id"]) ||
    !isset($resultado["pontos"]) ||
    !isset($resultado["acertos"]) ||
    !isset($assuntos[$resultado["assunto_id"]])
) {
    header("Location: index.php");
    exit;
}

$nome = $_SESSION["participante"]["nome"];
$turma = $_SESSION["participante"]["turma"];
$assunto = $assuntos[$resultado["assunto_id"]];
$pontos = $resultado["pontos"];
$acertos = $resultado["acertos"];

$erroSalvar = false;

if (
    ($_SESSION["resultado_quiz_salvo_id"] ?? null)
    !== $resultado["id_rodada"]
) {
    try {
        $sql = "INSERT INTO pontuacoes
                (nome, turma, assunto, pontos, acertos)
                VALUES
                (:nome, :turma, :assunto, :pontos, :acertos)";

        $consulta = $conexao->prepare($sql);

        $consulta->execute([
            ":nome" => $nome,
            ":turma" => $turma,
            ":assunto" => $assunto["nome"],
            ":pontos" => $pontos,
            ":acertos" => $acertos
        ]);

        $_SESSION["resultado_quiz_salvo_id"] =
            $resultado["id_rodada"];

    } catch (PDOException $erro) {
        $erroSalvar = true;
        error_log($erro->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Administração em Jogo</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f5f9;
            text-align: center;
            padding: 30px 15px;
        }

        main {
            max-width: 500px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 16px;
        }

        .pontos {
            font-size: 56px;
            font-weight: bold;
            color: #2563eb;
        }

        a {
            display: inline-block;
            margin: 8px;
            padding: 13px 20px;
            background: #172554;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<main>
    <h1>Rodada concluída!</h1>
    
    <?php if ($erroSalvar): ?>
        <p>
            Não foi possível salvar sua pontuação.
            Avise o responsável pelo jogo.
        </p>
    <?php endif; ?>

    <p>
        Parabéns, <?= htmlspecialchars($nome, ENT_QUOTES, "UTF-8") ?>!
    </p>

    <h2>
        <?= htmlspecialchars($assunto["nome"], ENT_QUOTES, "UTF-8") ?>
    </h2>

    <div class="pontos"><?= $pontos ?></div>
    <p>pontos conquistados</p>

    <p>Você acertou <?= $acertos ?> de 5 perguntas.</p>

    <?php if ($pontos === 100): ?>
        <h2>Excelente! Você acertou todas!</h2>
    <?php elseif ($pontos >= 60): ?>
        <h2>Muito bem! Continue assim!</h2>
    <?php else: ?>
        <h2>Continue aprendendo e tente novamente!</h2>
    <?php endif; ?>

    <a href="roleta.php">Jogar outra rodada</a>
    <a href="index.php">Voltar ao início</a>
    <a href="ranking.php">Ver Ranking Top 10</a>
</main>

</body>
</html>
