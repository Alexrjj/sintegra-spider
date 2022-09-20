# Teste de WebCrawler eStracta
### Criado utilizando PHP e cURL

Spider criado para extrair informações do Sintegra do Paraná, como parte do teste da empresa eStracta.

O Spider utiliza a biblioteca cURL para fazer as requisições HTTP, persistindo os cookies entre as requisições GET/POST.  Ao solicitar uma consulta, o Spider faz uma requisição GET do Captcha e grava a imagem em disco, bastando ao usuário digitar o código da imagem e CNPJ da empresa a ser pesquisada.

Logo após é retornado um array com as informações da empresa, caso o CNPJ seja válido.

Programa ainda em desenvolvimento.