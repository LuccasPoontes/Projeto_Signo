<?php
date_default_timezone_set('America/Sao_Paulo'); // Definir o fuso horário para São Paulo

include('header.php');
$data_nascimento = DateTime::createFromFormat('Y-m-d', $_POST['data_nascimento']);
if (!$data_nascimento || $data_nascimento->format('Y') > 9999) {
    echo "<div class='container text-center mt-5'>
            <p class='text-danger' style='font-size: 1.25rem; font-weight: bold;'>Data inválida! Por favor, insira uma data válida.</p>
            <a href='index.php' class='btn btn-secondary' style='font-size: 1.1rem;'>Voltar</a>
        </div>";
    exit;
}
// Validação de data no início do código
if (!isset($_POST['data_nascimento']) || !strtotime($_POST['data_nascimento'])) {
    echo "<p class='text-danger'>Por favor, forneça uma data válida.</p>";
    exit;
}

$signos = Simplexml_load_file('signos.xml');

function verificar_signo($data, $inicio, $fim) {
    $ano = $data->format('Y');
    $data_inicio = DateTime::createFromFormat('d/m/Y', "$inicio/$ano");
    $data_fim = DateTime::createFromFormat('d/m/Y', "$fim/$ano");
    if ($data_inicio > $data_fim) $data->format('m') == '01' ? $data_inicio->modify('-1 year') : $data_fim->modify('+1 year');
    return ($data >= $data_inicio && $data <= $data_fim);
}

$signo_encontrado = null;
foreach ($signos as $signo) {
    if (verificar_signo($data_nascimento, $signo->dataInicio, $signo->dataFim)) {
        $signo_encontrado = $signo;
        break;
    }
}

function formatar_nome_signo($nome) {
    $nome = strtolower($nome);

    // Substituição manual de acentos
    $acentos = [
        'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
        'ç' => 'c', 'ñ' => 'n',
        'Á' => 'a', 'À' => 'a', 'Ã' => 'a', 'Â' => 'a', 'Ä' => 'a',
        'É' => 'e', 'È' => 'e', 'Ê' => 'e', 'Ë' => 'e',
        'Í' => 'i', 'Ì' => 'i', 'Î' => 'i', 'Ï' => 'i',
        'Ó' => 'o', 'Ò' => 'o', 'Õ' => 'o', 'Ô' => 'o', 'Ö' => 'o',
        'Ú' => 'u', 'Ù' => 'u', 'Û' => 'u', 'Ü' => 'u',
        'Ç' => 'c', 'Ñ' => 'n'
    ];
    
    $nome = strtr($nome, $acentos);

    // Remove qualquer outro caractere que não seja letra
    $nome = preg_replace('/[^a-z]/', '', $nome);

    return $nome;
}

$nome_signo = formatar_nome_signo($signo_encontrado->signoNome);
$caminho_img = "../assets/imgs/{$nome_signo}.png";

echo "<!-- Caminho da imagem: $caminho_img -->";

?>
<body>
    <div class="container-fluid main-container d-flex align-items-center justify-content-center full-height">
        <div class="content-wrapper text-center p-5" style="max-width: 600px; background-color: white; border-radius: 15px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <?php if ($signo_encontrado): ?>
                <h1 class="text-primary mb-4" style="font-size: 2rem; font-weight: 700;">Seu Signo: <span class="text-success"><?= htmlspecialchars($signo_encontrado->signoNome) ?></span></h1>
                <p class="text-muted mb-5" style="font-size: 1.2rem;"><?= htmlspecialchars($signo_encontrado->descricao) ?></p>
                <img src="<?= $caminho_img ?>" alt="Imagem do signo <?= htmlspecialchars($signo_encontrado->signoNome) ?>" class="img-fluid mb-4" style="max-width: 100px; border-radius: 10px;">            <?php else: ?>
                <p class="text-danger mb-5" style="font-size: 1.25rem; font-weight: bold;">Não foi possível identificar o signo com a data fornecida. Tente novamente.</p>
            <?php endif; ?>
            <a href='index.php' class="btn btn-secondary" style="font-size: 1.1rem; padding: 10px 20px;">Voltar</a>
        </div>
    </div>
</body>
