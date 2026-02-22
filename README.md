# 📦 Sistema de Gerenciamento de Produtos e Anúncios (Laravel)

Sistema web desenvolvido em **Laravel** para gerenciamento de produtos e
anúncios com autenticação, autorização externa, integração com API
ViaCEP e controle de acesso baseado em usuário.

------------------------------------------------------------------------

# 📑 Sumário

-   Visão geral
-   Funcionalidades
-   Arquitetura
-   Integrações externas
-   Estrutura do banco
-   Instalação
-   Configuração
-   Execução
-   Fluxos críticos
-   Segurança
-   Estrutura do projeto

------------------------------------------------------------------------

# 📌 Visão Geral

O sistema permite que usuários autenticados gerenciem seus próprios
produtos e anúncios, com controle de acesso, validação externa de
autorização e preenchimento automático de dados via APIs.

Tecnologias:

-   PHP 8+
-   Laravel 11+
-   MySQL
-   Blade
-   JavaScript
-   REST APIs externas

------------------------------------------------------------------------

# 🚀 Funcionalidades

## Autenticação e controle de acesso

-   Login e Logout
-   Controle de acesso por usuário
-   Administrador gerencia usuários
-   Cliente gerencia apenas seus próprios registros

------------------------------------------------------------------------

## Produtos

CRUD completo com os campos:

-   Nome
-   Descrição
-   Preço
-   CEP
-   Bairro

### Integração ViaCEP

Consulta automática:

https://viacep.com.br/ws/{cep}/json/

Salva automaticamente:

-   Bairro
-   Logradouro
-   Cidade
-   UF
-   JSON completo

------------------------------------------------------------------------

## Anúncios

-   CRUD completo
-   Relacionamento muitos-para-muitos com produtos
-   Tabela intermediária: anuncio_produto
-   Campo quantidade permite múltiplas unidades do mesmo produto

------------------------------------------------------------------------

## Autorização externa obrigatória

Consulta:

https://util.devi.tools/api/v2/authorize

Se retornar:

    status: fail

A operação é bloqueada.

Arquivo responsável:

app/Services/DeviAuthorizeService.php

------------------------------------------------------------------------

## Filtro e Ordenação

Produtos e Anúncios possuem:

-   Pesquisa por texto
-   Ordenação por campos
-   Direção ascendente e descendente

Exemplo:

/produtos?q=notebook&sort=preco&dir=desc

------------------------------------------------------------------------

# 🗄 Estrutura do Banco

users produtos anuncios anuncio_produto

Relacionamentos:

User 1:N Produto User 1:N Anuncio Anuncio N:N Produto

------------------------------------------------------------------------

# ⚙️ Instalação

Instalar dependências:

    composer install
    npm install

Configurar .env:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3307
    DB_DATABASE=teste_tecnico_laravel
    DB_USERNAME=root
    DB_PASSWORD=sua_senha

Gerar chave:

    php artisan key:generate

Migrar banco:

    php artisan migrate --seed

Compilar frontend:

    npm run build

Executar:

    php artisan serve

------------------------------------------------------------------------

# 🔐 Fluxos Críticos

Criação de Produto:

-   Consulta ViaCEP
-   Salva dados automaticamente

Criação de Anúncio:

-   Consulta API authorize
-   Bloqueia ou permite salvar

------------------------------------------------------------------------

# 🛡 Segurança

-   Middleware auth
-   Proteção CSRF
-   Escopo por usuário
-   Validação externa

------------------------------------------------------------------------

# 📁 Estrutura do Projeto

app/ database/ resources/ routes/

------------------------------------------------------------------------

# 👨‍💻 Autor

Yuriel Machado da Costa de Abreu
