
<?php
session_start();
require_once "assuntos.php";

if (!isset($_SESSION["participante"])) {
    header("Location: cadastro.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(INPUT_POST, "assunto_id", FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null && isset($assuntos[$id])) {
        $_SESSION["assunto_id"] = $id;

        header("Location: historia.php");
        exit;
    }
}

$nome = $_SESSION["participante"]["nome"];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Roleta - Administração em Jogo</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            background: linear-gradient(135deg, #eff6ff, #e2e8f0);
            color: #172554;
            margin: 0;
            min-height: 100vh;
            padding: 30px 16px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 580px;
            margin: auto;
            background: #ffffff;
            padding: clamp(20px, 5vw, 36px);
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        h1 {
            font-size: clamp(24px, 5vw, 34px);
            line-height: 1.2;
            margin: 0 0 18px;
            overflow-wrap: anywhere;
        }

        .saudacao {
            font-size: 17px;
            color: #334155;
            overflow-wrap: anywhere;
        }

        .instrucao {
            font-size: 15px;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 22px;
        }

        .ponteiro {
            color: #e63946;
            font-size: clamp(30px, 8vw, 40px);
            line-height: 1;
            position: relative;
            z-index: 2;
            margin-bottom: -2px;
        }

        .roleta {
            width: min(100%, 340px);
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            margin: 0 auto 26px;
            border: 6px solid #172554;
            position: relative;
            background: conic-gradient(
                #2563eb 0deg 90deg,
                #f59e0b 90deg 180deg,
                #16a34a 180deg 270deg,
                #9333ea 270deg 360deg
            );
            transition: transform 4s cubic-bezier(.12, .7, .12, 1);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.18);
        }

        .setor {
            position: absolute;
            width: 43%;
            font-size: clamp(10px, 2.7vw, 14px);
            font-weight: bold;
            line-height: 1.25;
            color: #ffffff;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.7);
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .s1 {
            top: 23%;
            right: 3%;
        }

        .s2 {
            bottom: 23%;
            right: 3%;
        }

        .s3 {
            bottom: 23%;
            left: 3%;
        }

        .s4 {
            top: 23%;
            left: 3%;
        }

        button {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            background: #172554;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.2s, transform 0.2s;
        }

        button:hover:not(:disabled) {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        button:focus-visible {
            outline: 3px solid #f59e0b;
            outline-offset: 4px;
        }

        button:disabled {
            opacity: 0.65;
            cursor: wait;
        }

        #mensagem {
            min-height: 24px;
            margin: 18px 0 0;
            font-size: 14px;
            line-height: 1.5;
            font-weight: bold;
            color: #1d4ed8;
        }

        @media (max-width: 400px) {
            body {
                padding: 14px 10px;
                align-items: flex-start;
            }

            .container {
                padding: 22px 14px;
                border-radius: 16px;
            }

            .roleta {
                border-width: 4px;
                margin-bottom: 22px;
            }

            .setor {
                font-size: clamp(9px, 2.8vw, 11px);
            }

            .s1, .s4 {
                top: 22%;
            }

            .s2, .s3 {
                bottom: 22%;
            }

            button {
                padding: 15px 12px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .roleta {
                transition-duration: 0.01ms;
            }

            button {
                transition: none;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Administração em Jogo</h1>

    <p class="saudacao">
        Olá,
        <?= htmlspecialchars($nome, ENT_QUOTES, "UTF-8") ?>!
    </p>

    <p class="instrucao">
        Gire a roleta para descobrir seu desafio.
    </p>

    <div class="ponteiro" aria-hidden="true">▼</div>

    <div
        class="roleta"
        id="roleta"
        role="img"
        aria-label="Roleta com quatro assuntos de Administração"
    >
        <div class="setor s1">Operações e Logística</div>
        <div class="setor s2">Empreendedorismo</div>
        <div class="setor s3">Recursos Humanos</div>
        <div class="setor s4">Finanças e Contabilidade</div>
    </div>

    <form method="POST" id="formRoleta">
        <input type="hidden" name="assunto_id" id="assuntoId">

        <button
            type="button"
            id="botaoGirar"
            onclick="girarRoleta()"
        >
            GIRAR ROLETA
        </button>
    </form>

    <p id="mensagem" aria-live="polite"></p>
</div>

<script>
    const roleta = document.getElementById("roleta");
    const botao = document.getElementById("botaoGirar");
    const mensagem = document.getElementById("mensagem");
    const assuntoId = document.getElementById("assuntoId");
    const formulario = document.getElementById("formRoleta");

    let girando = false;
    let rotacaoAtual = 0;

    function girarRoleta() {
        if (girando) return;

        girando = true;
        botao.disabled = true;
        mensagem.textContent = "A roleta está girando...";

        const sorteado = Math.floor(Math.random() * 4) + 1;

        const anguloCentro = (sorteado - 1) * 90 + 45;
        const ajuste = (360 - anguloCentro) % 360;

        const rotacaoFinal = rotacaoAtual +
            360 * 5 +
            ((ajuste - (rotacaoAtual % 360) + 360) % 360);

        rotacaoAtual = rotacaoFinal;
        roleta.style.transform = `rotate(${rotacaoFinal}deg)`;

        roleta.addEventListener("transitionend", function concluir() {
            roleta.removeEventListener("transitionend", concluir);

            assuntoId.value = sorteado;
            mensagem.textContent =
                "Resultado definido! Preparando sua história...";

            formulario.submit();
        });
    }
</script>

</body>
</html>
