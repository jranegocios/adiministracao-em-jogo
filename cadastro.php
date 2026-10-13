
<?php
session_start();

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $turma = trim($_POST["turma"] ?? "");

    if ($nome === "" || $turma === "") {
        $erro = "Preencha todos os campos.";
    } else {
        $_SESSION["participante"] = [
            "nome" => $nome,
            "turma" => $turma
        ];

        header("Location: roleta.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro - Administração em Jogo</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;

            background: linear-gradient(
                135deg,
                #0f172a,
                #1e3a8a,
                #2563eb
            );
        }

        .container {
            width: 100%;
            max-width: 460px;
        }

        .cabecalho {
            text-align: center;
            color: white;
            margin-bottom: 25px;
        }

        .icone {
            font-size: 48px;
            margin-bottom: 12px;
        }

        .cabecalho h1 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .cabecalho p {
            font-size: 15px;
            line-height: 1.6;
            color: #dbeafe;
        }

        .card {
            background: #ffffff;
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.22);
        }

        .card h2 {
            color: #172554;
            font-size: 23px;
            margin-bottom: 10px;
        }

        .descricao {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 26px;
        }

        .campo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #334155;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 16px;
            color: #0f172a;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            background: #ffffff;
        }

        .erro {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .botao {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: #facc15;
            color: #172554;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .botao:hover {
            background: #eab308;
            transform: translateY(-2px);
        }

        .botao:focus-visible,
        .voltar:focus-visible {
            outline: 3px solid #2563eb;
            outline-offset: 3px;
        }

        .voltar {
            display: block;
            text-align: center;
            margin-top: 22px;
            color: #dbeafe;
            text-decoration: none;
            font-size: 14px;
        }

        .voltar:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .rodape {
            text-align: center;
            margin-top: 22px;
            color: #dbeafe;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            body {
                padding: 18px;
            }

            .cabecalho h1 {
                font-size: 25px;
            }

            .card {
                padding: 24px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <header class="cabecalho">
            <div class="icone" aria-hidden="true">🎯</div>

            <h1>Administração em Jogo</h1>

            <p>
                Aprenda, desafie seus conhecimentos
                e conquiste seu lugar no ranking!
            </p>
        </header>

        <main class="card">

            <h2>Cadastro do participante</h2>

            <p class="descricao">
                Informe seus dados para começar essa experiência.
            </p>

            <?php if ($erro !== ""): ?>
                <p class="erro" role="alert">
                    <?= htmlspecialchars($erro, ENT_QUOTES, "UTF-8") ?>
                </p>
            <?php endif; ?>

            <form method="POST" action="cadastro.php">

                <div class="campo">
                    <label for="nome">Nome completo</label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        maxlength="100"
                        autocomplete="name"
                        placeholder="Digite seu nome completo"
                        value="<?= htmlspecialchars($_POST["nome"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="turma">Turma ou curso</label>

                    <input
                        type="text"
                        id="turma"
                        name="turma"
                        maxlength="100"
                        autocomplete="off"
                        placeholder="Ex.: Administração - 1º ano"
                        value="<?= htmlspecialchars($_POST["turma"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                        required
                    >
                </div>

                <button type="submit" class="botao">
                    Continuar para o jogo →
                </button>

            </form>

        </main>

        <a href="index.php" class="voltar">
            ← Voltar para a página inicial
        </a>

        <footer class="rodape">
            Conhecimento que vira conquista.
        </footer>

    </div>

</body>
</html>
