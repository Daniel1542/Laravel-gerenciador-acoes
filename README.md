
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Gerenciador de ações e fundos imobiliários.

Este projeto é um site para auxiliar na declaração de imposto de renda de ações e fundos imobiliários.

### Recursos Principais

- Framework Laravel
- Bootstrap
- BLADE
- CSS
- PHP
- Javascript
- Jquery
- Banco de dados SQL
- Api rest
- Code Sniffer
- PhpUnit
- Vue.js
- Opção de baixar dados em formato Excel e PDF

### Instalação

1. Clone o repositório.
2. Execute `composer update`.
3. Crie um arquivo `.env`.
4. Copie o arquivo `.env.example` para `.env` e ajuste as configurações, como a conexão com o banco de dados.
5. Execute `php artisan key:generate`.
6. Inicie o banco de dados.
7. Execute `php artisan migrate --seed` para criar as tabelas no banco de dados com as migrações e sementes.

### Uso

- Execute `php artisan serve` para iniciar o servidor local.
- Execute `npm run build` para iniciar o Vue.js.
- Acesse o aplicativo em http://localhost:8000.
- Faça a conexão com a api pelo postman se quiser testar a api rest.
- É possivel também utilizar Docker.

### Screenshot

![Screenshot login](storage/imagens/login.png)

![Screenshot dashboard](storage/imagens/dashboard.png)

![Screenshot dash](storage/imagens/dash.png)

![Screenshot formulas](storage/imagens/formulas.png)

![Screenshot movimentações](storage/imagens/movimentos.png)

### Diagramas

![Screenshot Diagrama](storage/imagens/Diagrama.png)

![Screenshot Diagrama banco de dados](storage/imagens/drawSQL.png)

## Contribuição

Sinta-se à vontade para contribuir com melhorias ou relatar problemas.

## Licença

O framework Laravel é um software de código aberto licenciado sob a [licença MIT](https://opensource.org/licenses/MIT).
