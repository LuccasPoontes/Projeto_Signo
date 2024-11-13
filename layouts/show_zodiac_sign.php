<?php
include('header.php');
$data_nascimento = DateTime::createFromFormat('Y-m-d', $_POST['data_nascimento']);
if (!$data_nascimento || $data_nascimento->format('Y') > 9999) {
    echo "<p class='text-danger'>Data inválida! Por favor, insira uma data correta.</p>";
    echo "<a href='index.php' class='btn btn-secondary'>Voltar</a>";
    exit;
}
$signos = Simplexml_load_file('signos.xml');
function verificar_signo($data, $inicio, $fim){
    $ano = $data->format('Y');
    $data_inicio = DateTime::createFromFormat('d/m/Y',"$inicio/$ano");
    $data_fim = DateTime::createFromFormat('d/m/Y',"$fim/$ano");
    if($data_inicio > $data_fim) $data->format('m') == '01' ? $data_inicio->modify('-1 year') : $datafim->modify('+1 year');
    return( $data >= $data_inicio && $data <= $data_fim);
}
$signo_encontrado=null;
foreach($signos as $signo){
    if(verificar_signo($data_nascimento,$signo->dataInicio, $signo->dataFim)){
        $signo_encontrado = $signo;
        break;
    }
}
?>
<body>
    <div class="container-fluid main-container d-flex align-items-center justify-content-center full-height">
    <div class="content-wrapper text-center p-5 custom-style">
    
            <?php if ($signo_encontrado): ?>
                <h1 class="text-primary mb-4">Seu signo é: <?= htmlspecialchars ($signo_encontrado->signoNome) ?></h1>
                <p class="text-muted mb-5"><?= htmlspecialchars($signo_encontrado->descricao) ?></p>
            <?php else: ?>
                <p class="text-danger mb-5">Data inválida! Não foi possível encontrar um signo correspondente.</p>
            <?php endif; ?>
            <a href='index.php' class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</body>