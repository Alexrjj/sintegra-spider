<?php

namespace {
    include("functions.php");
    use funcoes\Spider;

    try {
        // Inicializa o objeto Spider
        $spider = new Spider();

        // Acessa a URL contendo o Captcha e grava a imagem em disco
        // TODO: Identificar captcha incorreto e solicitar novamente
        $spider->getCaptcha();

        // Pesquisa pelo CNPJ e retorna o HTML da página no formato utf-8
        // TODO: Identificar CNPJ não encontrado/cadastrado
        $html = $spider->getInfoByCnpj();

        // Retorna texto, sem as tags HTML, contendo os dados da empresa
        // TODO: Implementar o parse do HTML retornando um array com os dados da empresa
        // TODO: Capturar diversas inscrições estaduais de um mesmo CNPJ
        $spider->domParser($html);


    } catch (\Exception $e) {
        echo $e->getMessage();
    }

}