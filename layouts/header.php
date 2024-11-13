<?php
// Cabeçalhos de Segurança
// Content Security Policy (CSP): restringe fontes de carregamento para scripts e estilos.
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net;");
// X-Content-Type-Options: evita a tentativa do navegador de deduzir o tipo MIME dos arquivos.
header("X-Content-Type-Options: nosniff");
// X-Frame-Options: impede que a página seja carregada em um iframe de outro domínio (proteção contra clickjacking).
header("X-Frame-Options: SAMEORIGIN");
// X-XSS-Protection: ativa a proteção contra ataques XSS em navegadores mais antigos.
header("X-XSS-Protection: 1; mode=block");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Signo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"> 
</head>