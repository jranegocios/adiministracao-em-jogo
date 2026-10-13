
<?php
session_start();
require_once "assuntos.php";

if (!isset($_SESSION["participante"], $_SESSION["assunto_id"])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION["assunto_id"];

if (!isset($assuntos[$id])) {
    header("Location: roleta.php");
    exit;
}

$assunto = $assuntos[$id];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>História - Administração em Jogo</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f5f9;
            margin: 0;
            padding: 25px 15px;
            text-align: center;
        }

        main {
            max-width: 850px;
            margin: auto;
        }

        .quadrinhos {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin: 25px 0;
        }

        .quadrinho {
            background: white;
            border: 3px solid #172554;
            border-radius: 12px;
            padding: 18px;
            text-align: left;
            min-height: 140px;
        }

        .personagem {
            font-size: 38px;
        }

        .fala {
            background: #e8efff;
            border-radius: 10px;
            padding: 12px;
            line-height: 1.5;
        }

        button {
            background: #172554;
            color: white;
            border: 0;
            border-radius: 8px;
            padding: 14px 24px;
            font-size: 16px;
            cursor: pointer;
        }

        @media (max-width: 520px) {
            .quadrinhos {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<main>
    <h1>Uma história de Administração</h1>

    <h2>
        <?= htmlspecialchars($assunto["nome"], ENT_QUOTES, "UTF-8") ?>
    </h2>

    <p>
        <?= htmlspecialchars($assunto["descricao"], ENT_QUOTES, "UTF-8") ?>
    </p>

    <div class="quadrinhos">
        <?php foreach ($assunto["quadrinhos"] as $i => $quadrinho): ?>
            <article class="quadrinho">
                <span class="personagem" aria-hidden="true">
                    <?= $i % 2 === 0 ? "👩‍💼" : "👨‍💼" ?>
                </span>

                <h3>
                    Quadrinho <?= $i + 1 ?>
                </h3>

                <strong>
                    <?= htmlspecialchars(
                        $quadrinho["personagem"],
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>
                </strong>

                <p class="fala">
                    <?= htmlspecialchars(
                        $quadrinho["fala"],
                        ENT_QUOTES,
                        "UTF-8"
                    ) ?>
                </p>
            </article>
        <?php endforeach; ?>
    </div>

    <p>Preparado para testar seus conhecimentos?</p>

    <form action="quiz.php" method="GET">
        <button type="submit">Começar o quiz</button>
    </form>
</main>

</body>
</html>
