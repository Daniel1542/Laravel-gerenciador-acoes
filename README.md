
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Gerenciador de ações e fundo imobiliários

Este projeto é um site ainda em desenvolvimento para auxiliar na declaração de imposto de renda de ações e fundos imobiliários.

![Exemplo de Screenshot](imagens/cadastro.png)

![Exemplo de Screenshot](imagens/dashboard.png)

![Exemplo de Screenshot](imagens/ir.png)

![Exemplo de Screenshot](imagens/ir2.png)

![Exemplo de Screenshot](imagens/login.png)

![Exemplo de Screenshot](imagens/movimento.png)

### Recursos Principais

- Framework Laravel
- Bootstrap para o design responsivo
- BLADE
- CSS
- PHP
- Javascript para fazer ajax
- Banco de dados SQL
- Api rest
- Code Sniffer
- phpUnit
- Laragon
- CRUD (Create, Read, Update, Delete)
- Opção de baixar dados em formato Excel e PDF

### Instalação

1. Clone o repositório.
2. Execute `composer install`.
3. Crie um arquivo `.env`.
3. Copie o arquivo `.env.example` para `.env` e ajuste as configurações, como a conexão com o banco de dados.
4. Execute o Laragon para iniciar o banco de dados.
5. Execute `php artisan migrate --seed` para criar as tabelas no banco de dados com as migrações e sementes, se aplicável.

### Uso

- Execute `php artisan serve` para iniciar o servidor local.
- Acesse o aplicativo em http://localhost:8000.
- Faça a conexão com a api pelo postman se quiser testar a api rest.

## Contribuição

Sinta-se à vontade para contribuir com melhorias ou relatar problemas.

## Licença

O framework Laravel é um software de código aberto licenciado sob a [licença MIT](https://opensource.org/licenses/MIT).
