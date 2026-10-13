
<?php
session_start();
require_once "assuntos.php";

if (!isset($_SESSION["participante"], $_SESSION["assunto_id"])) {
    header("Location: index.php");
    exit;
}

$assuntoId = (int) $_SESSION["assunto_id"];

if (!isset($assuntos[$assuntoId])) {
    header("Location: roleta.php");
    exit;
}

// Banco inicial de perguntas: cinco por assunto.
$quizzes = [
    1 => [
        [
            "pergunta" => "Qual é o objetivo da logística?",
            "opcoes" => [
                "Organizar o fluxo de produtos e informações",
                "Contratar somente funcionários",
                "Calcular exclusivamente os salários",
                "Criar propagandas"
            ],
            "correta" => 0
        ],
        [
            "pergunta" => "O que é controle de estoque?",
            "opcoes" => [
                "Aumentar os preços diariamente",
                "Acompanhar entradas, saídas e quantidades de produtos",
                "Registrar apenas as vendas",
                "Eliminar todos os produtos armazenados"
            ],
            "correta" => 1
        ],
        [
            "pergunta" => "Para que serve o planejamento de rotas?",
            "opcoes" => [
                "Aumentar o percurso",
                "Evitar o controle de entregas",
                "Organizar trajetos e melhorar a eficiência das entregas",
                "Substituir o atendimento ao cliente"
            ],
            "correta" => 2
        ],
        [
            "pergunta" => "O que pode ajudar a evitar a falta de produtos?",
            "opcoes" => [
                "Ignorar as vendas",
                "Comprar sem planejamento",
                "Deixar de registrar o estoque",
                "Monitorar o estoque e planejar a reposição"
            ],
            "correta" => 3
        ],
        [
            "pergunta" => "Qual indicador ajuda a avaliar as entregas?",
            "opcoes" => [
                "Percentual de entregas no prazo",
                "Número de reuniões festivas",
                "Quantidade de anúncios",
                "Número de cargos da empresa"
            ],
            "correta" => 0
        ]
    ],

    2 => [
        [
            "pergunta" => "O que é empreendedorismo?",
            "opcoes" => [
                "Evitar todas as mudanças",
                "Identificar oportunidades e desenvolver iniciativas",
                "Trabalhar sem planejamento",
                "Copiar qualquer negócio"
            ],
            "correta" => 1
        ],
        [
            "pergunta" => "Para que serve um plano de negócios?",
            "opcoes" => [
                "Eliminar todos os riscos",
                "Garantir lucro imediato",
                "Organizar objetivos, mercado, custos e estratégias",
                "Dispensar o conhecimento dos clientes"
            ],
            "correta" => 2
        ],
        [
            "pergunta" => "O que é público-alvo?",
            "opcoes" => [
                "Todos os concorrentes",
                "Somente os funcionários",
                "A lista de fornecedores",
                "O grupo de clientes que o negócio pretende atender"
            ],
            "correta" => 3
        ],
        [
            "pergunta" => "Por que pesquisar o mercado?",
            "opcoes" => [
                "Para entender clientes, concorrentes e oportunidades",
                "Para dispensar o planejamento financeiro",
                "Para evitar ouvir os clientes",
                "Para definir preços sem informações"
            ],
            "correta" => 0
        ],
        [
            "pergunta" => "O que são custos em um negócio?",
            "opcoes" => [
                "Apenas o dinheiro recebido",
                "Gastos relacionados à operação e à oferta de produtos ou serviços",
                "Somente o lucro final",
                "Apenas os empréstimos pessoais"
            ],
            "correta" => 1
        ]
    ],

    3 => [
        [
            "pergunta" => "Qual é uma função de Recursos Humanos?",
            "opcoes" => [
                "Controlar exclusivamente os estoques",
                "Organizar rotas de entrega",
                "Apoiar recrutamento, desenvolvimento e gestão de pessoas",
                "Registrar somente as vendas"
            ],
            "correta" => 2
        ],
        [
            "pergunta" => "O que é recrutamento?",
            "opcoes" => [
                "O cálculo do lucro",
                "A conferência de mercadorias",
                "O fechamento do caixa",
                "O processo de atrair candidatos para vagas"
            ],
            "correta" => 3
        ],
        [
            "pergunta" => "Para que serve o treinamento?",
            "opcoes" => [
                "Desenvolver conhecimentos e habilidades profissionais",
                "Substituir toda a comunicação",
                "Eliminar o planejamento",
                "Reduzir todas as responsabilidades"
            ],
            "correta" => 0
        ],
        [
            "pergunta" => "O que favorece o trabalho em equipe?",
            "opcoes" => [
                "Esconder informações",
                "Comunicação e colaboração",
                "Evitar o diálogo",
                "Ignorar objetivos comuns"
            ],
            "correta" => 1
        ],
        [
            "pergunta" => "O que é clima organizacional?",
            "opcoes" => [
                "A previsão do tempo na empresa",
                "O controle do estoque",
                "A percepção das pessoas sobre o ambiente de trabalho",
                "O cálculo dos impostos"
            ],
            "correta" => 2
        ]
    ],

    4 => [
        [
            "pergunta" => "O que são receitas?",
            "opcoes" => [
                "Somente as dívidas",
                "Todos os gastos de uma empresa",
                "Apenas os impostos pagos",
                "Valores obtidos por vendas ou outras fontes de rendimento"
            ],
            "correta" => 3
        ],
        [
            "pergunta" => "O que são despesas?",
            "opcoes" => [
                "Gastos incorridos para manter as atividades da organização",
                "Somente o dinheiro recebido",
                "O total de clientes cadastrados",
                "A quantidade de mercadorias vendidas"
            ],
            "correta" => 0
        ],
        [
            "pergunta" => "Para que serve o fluxo de caixa?",
            "opcoes" => [
                "Organizar as férias dos funcionários",
                "Acompanhar as entradas e saídas de dinheiro",
                "Controlar exclusivamente o estoque",
                "Calcular o número de clientes"
            ],
            "correta" => 1
        ],
        [
            "pergunta" => "Qual é a finalidade da contabilidade?",
            "opcoes" => [
                "Substituir o planejamento",
                "Organizar apenas reuniões",
                "Registrar e fornecer informações sobre o patrimônio e os resultados",
                "Controlar somente os horários"
            ],
            "correta" => 2
        ],
        [
            "pergunta" => "Se as receitas forem R$ 1.000 e as despesas R$ 700, qual será o resultado dessa diferença?",
            "opcoes" => [
                "R$ 1.700",
                "R$ 700",
                "R$ 100",
                "R$ 300 positivos"
            ],
            "correta" => 3
        ]
    ]
];

$perguntas = $quizzes[$assuntoId];

// Inicia uma rodada nova quando o assunto muda.
if (
    !isset($_SESSION["quiz_assunto_id"]) ||
    $_SESSION["quiz_assunto_id"] !== $assuntoId
) {
    $_SESSION["quiz_assunto_id"] = $assuntoId;
    $_SESSION["quiz_indice"] = 0;
    $_SESSION["quiz_pontos"] = 0;
    $_SESSION["quiz_inicio"] = null;
}

$indice = (int) $_SESSION["quiz_indice"];

// Processa a resposta da pergunta atual.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $indiceEnviado = filter_input(
        INPUT_POST,
        "indice",
        FILTER_VALIDATE_INT
    );

    if ($indiceEnviado !== $indice || $indice >= count($perguntas)) {
        header("Location: quiz.php");
        exit;
    }

    $inicio = $_SESSION["quiz_inicio"];

    if ($inicio === null) {
        header("Location: quiz.php");
        exit;
    }

    $tempoDecorrido = microtime(true) - $inicio;
    $resposta = $_POST["resposta"] ?? "";

    // A resposta só vale se chegar dentro do limite.
    if (
        $tempoDecorrido <= 25 &&
        $resposta !== "" &&
        filter_var($resposta, FILTER_VALIDATE_INT) !== false &&
        (int) $resposta === $perguntas[$indice]["correta"]
    ) {
        $_SESSION["quiz_pontos"] += 20;
    }

    $_SESSION["quiz_indice"]++;
    $_SESSION["quiz_inicio"] = null;

    if ($_SESSION["quiz_indice"] >= count($perguntas)) {
        // $_SESSION["resultado_quiz"] = [
        //     "assunto_id" => $assuntoId,
        //     "pontos" => $_SESSION["quiz_pontos"],
        //     "acertos" => (int) ($_SESSION["quiz_pontos"] / 20)
        // ];
        
        // Isso ajudará a evitar que uma atualização da página registre a mesma rodada duas vezes.
        $_SESSION["resultado_quiz"] = [
            "id_rodada" => bin2hex(random_bytes(16)),
            "assunto_id" => $assuntoId,
            "pontos" => $_SESSION["quiz_pontos"],
            "acertos" => $_SESSION["quiz_pontos"] / 20
        ];


        header("Location: resultado.php");
        exit;
    }

    header("Location: quiz.php");
    exit;
}

$indice = (int) $_SESSION["quiz_indice"];
$pergunta = $perguntas[$indice];

// O tempo não reinicia ao atualizar a página.
if ($_SESSION["quiz_inicio"] === null) {
    $_SESSION["quiz_inicio"] = microtime(true);
}

$inicioMs = (int) round($_SESSION["quiz_inicio"] * 1000);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Administração em Jogo</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f5f9;
            margin: 0;
            padding: 25px 15px;
        }

        main {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 16px;
        }

        .progresso {
            color: #475569;
        }

        #tempo {
            font-size: 34px;
            font-weight: bold;
            color: #172554;
        }

        .barra {
            height: 10px;
            background: #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 22px;
        }

        #barraTempo {
            height: 100%;
            width: 100%;
            background: #2563eb;
            transition: width .1s linear;
        }

        .opcao {
            display: block;
            width: 100%;
            text-align: left;
            padding: 15px;
            margin: 10px 0;
            border: 2px solid #cbd5e1;
            border-radius: 10px;
            background: white;
            color: #172554;
            cursor: pointer;
            font-size: 16px;
        }

        .opcao:focus {
            outline: 3px solid #93c5fd;
        }

        .opcao:disabled {
            opacity: .65;
            cursor: default;
        }
    </style>
</head>
<body>

<main>
    <p class="progresso">
        Pergunta <?= $indice + 1 ?> de <?= count($perguntas) ?>
    </p>

    <h1>
        <?= htmlspecialchars(
            $assuntos[$assuntoId]["nome"],
            ENT_QUOTES,
            "UTF-8"
        ) ?>
    </h1>

    <div id="tempo" aria-live="off">5</div>
    <div class="barra">
        <div id="barraTempo"></div>
    </div>

    <h2>
        <?= htmlspecialchars(
            $pergunta["pergunta"],
            ENT_QUOTES,
            "UTF-8"
        ) ?>
    </h2>

    <form method="POST" id="formQuiz">
        <input type="hidden" name="indice" value="<?= $indice ?>">
        <input type="hidden" name="resposta" id="resposta">

        <?php foreach ($pergunta["opcoes"] as $i => $opcao): ?>
            <button
                class="opcao"
                type="button"
                onclick="responder(<?= $i ?>)"
            >
                <?= chr(65 + $i) ?>)
                <?= htmlspecialchars($opcao, ENT_QUOTES, "UTF-8") ?>
            </button>
        <?php endforeach; ?>
    </form>
</main>

<script>
    const form = document.getElementById("formQuiz");
    const campoResposta = document.getElementById("resposta");
    const tempoElemento = document.getElementById("tempo");
    const barraTempo = document.getElementById("barraTempo");

    const inicio = <?= $inicioMs ?>;
    // const responsavel por quantidade de segundos por milisegundos
    /*
        1 segundo = 1.000 milissegundos
        1 minuto = 60.000 milissegundos
        10 minutos = 600.000 milissegundos
    */ 
    const limite = inicio + 25000; //A cada pergunta tera 25 segundos

    let enviado = false;

    function enviarResposta(valor) {
        if (enviado) return;

        enviado = true;
        campoResposta.value = valor;
        form.querySelectorAll("button").forEach(botao => {
            botao.disabled = true;
        });

        form.submit();
    }

    function responder(indice) {
        enviarResposta(indice);
    }

    function atualizarTempo() {
        if (enviado) return;

        const restante = Math.max(0, limite - Date.now());
        const segundos = Math.ceil(restante / 1000);//Isso faz a barra visual acompanhar os 25 segundos

        tempoElemento.textContent = segundos;
        barraTempo.style.width = (restante / 25000 * 100) + "%";

        if (restante <= 0) {
            enviarResposta("");
            return;
        }

        requestAnimationFrame(atualizarTempo);
    }

    atualizarTempo();
</script>

</body>
</html>
