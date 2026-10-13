
<?php
$titulo = "Administração em Jogo";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #172554;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
        }

        main {
            width: 100%;
            max-width: 650px;
            background: #ffffff;
            text-align: center;
            padding: 55px 35px;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(23, 37, 84, 0.12);
        }

        .icone {
            font-size: 58px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: clamp(30px, 5vw, 44px);
            line-height: 1.15;
            font-weight: 800;
            margin-bottom: 18px;
            color: #172554;
        }

        h1 span {
            color: #2563eb;
        }

        .descricao {
            font-size: 18px;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 32px;
        }

        .acoes {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .botao {
            display: block;
            width: 100%;
            padding: 16px 22px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 17px;
            font-weight: bold;
            transition: transform 0.2s, background 0.2s,
                        box-shadow 0.2s;
        }

        .botao-jogar {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.2);
        }

        .botao-jogar:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 9px 18px rgba(37, 99, 235, 0.25);
        }

        .botao-ranking {
            background: #ffffff;
            color: #172554;
            border: 2px solid #dbeafe;
        }

        .botao-ranking:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            transform: translateY(-2px);
        }

        .rodape {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 13px;
            color: #94a3b8;
        }

        @media (max-width: 480px) {
            main {
                padding: 38px 22px;
                border-radius: 18px;
            }

            .descricao {
                font-size: 16px;
            }

            .botao {
                font-size: 16px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <main>
        <div class="icone" aria-hidden="true">🎯</div>

        <h1>
            Administração<br>
            <span>em Jogo</span>
        </h1>

        <p class="descricao">
            Aprenda Administração jogando!
            Gire a roleta, descubra os desafios,
            teste seus conhecimentos e conquiste
            seu lugar no Top 10.
        </p>

        <nav class="acoes" aria-label="Menu principal">
            <a href="cadastro.php" class="botao botao-jogar">
                🎮 Começar jogo
            </a>

            <a href="ranking.php" class="botao botao-ranking">
                🏆 Ver Ranking Top 10
            </a>
        </nav>

        <footer class="rodape">
            Aprender, jogar e evoluir!
        </footer>
    </main>

</body>
</html>
