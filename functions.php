<?php

namespace funcoes {

    class Spider
    {
        // Inicializa as variáveis de classe
        public string $baseURL = "http://www.sintegra.fazenda.pr.gov.br/sintegra/";
        public string $cookieFile = "cookies.txt";

        // Inicializa e retorna o objeto CURL
        // Pesquisa pelo CNPJ e retorna o HTML da página no formato utf-8
        public function getInfoByCnpj(): string
        {
            $curl = curl_init($this->baseURL);
            $options = $this->getDefaultHeaders();
            $captcha = readline('Digite o código: ');
            $cnpj = readline('Digite o CNPJ: ');
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = [
                "_method" => "POST",
                "data[Sintegra1][CodImage]" => $captcha,
                "data[Sintegra1][Cnpj]" => $cnpj,
                "empresa" => "Consultar Empresa",
            ];

            curl_setopt_array($curl, $options);
            $response = curl_exec($curl);
            curl_close($curl);
            return iconv("ISO-8859-1","UTF-8",$response);
        }

        // Retorna o arquivo de ccokies
        public function getcookieFile(): string
        {
            return $this->cookieFile;
        }

        // Define as opções do CURL para ser enviado na requisição
        public function getDefaultHeaders(): array
        {
            return [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_COOKIEJAR => $this->getCookieFile(),
                CURLOPT_COOKIEFILE => $this->getCookieFile(),
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36 Edg/105.0.1343.33",
                CURLOPT_REFERER => $this->baseURL,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
//                CURLOPT_VERBOSE => true,
            ];
        }

        // Acessa a URL contendo o Captcha e grava a imagem em disco
        public function getCaptcha(): void
        {
            $curl = curl_init($this->baseURL . "captcha");
            $options = $this->getDefaultHeaders();

            curl_setopt_array($curl, $options);

            $data = curl_exec($curl);
            curl_close($curl);

            $fp = fopen("code.jpeg", "w");
            fwrite($fp, $data);
            fclose($fp);
        }

        // Faz o parse do HTML e retorna um array com os dados
        public function domParser(string $html): void
        {
            $dom = new \DOMDocument();
            $dom->loadHTML($html);
            $dom->preserveWhiteSpace = false;
            $table = $dom->getElementById("Sintegra1ConsultarForm");
            $rows = $table->getElementsByTagName('tr');
            foreach ($rows as $row) {
                $cols = $row->getElementsByTagName('td');
                foreach ($cols as $col) {
                    $text = $col->nodeValue;
                    echo $text . PHP_EOL;
                }
            }
        }
    }
}