# Bookit

Um marketplace de livros usados pensado para as cidades do noroeste capixaba.

## Sumário

- [Tarefas](#tarefas)
- [Requisitos](#requisitos)
- [Comandos](#comandos)

## Tarefas

### Backend

- ⬜ Modelar banco de dados inicial
- ⬜ Criar Controllers base 
- ⬜ Criar rotas, validações e middlewares base 
- ⬜ Implementar autenticação 
- ⬜ Escrever testes (Pest)
- ⬜ Documentar

### Frontend

- ⬜ Rotas base do projeto
- ⬜ Criar componentes base
- ⬜ Criar layout principal
- ⬜ Conectar layout com o backend
- ⬜ Documentar

### Infra

- ✅ Definir stack (Laravel + Vue + Inertia)
- ✅ Definir banco de dados (Postgres)
- ⬜ Definir infraestrutura na AWS

## Requisitos

- [xampp junto do php](https://www.apachefriends.org/)
- [composer](https://getcomposer.org/)
- [node](https://nodejs.org/)
- [yarn](https://yarnpkg.com/)

## Comandos

### Fazer setup do projeto 

Rode isso ao clonar o repósitório

```bash
# laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

# vue
yarn
```

### Rodar projeto

```bash
composer run dev
# ou 
composer dev
```

### Instalar package (Laravel)

Instalar qualquer biblioteca

```bash
composer require nome_do_package
```

### Instalar package (Vue)

Instalar qualquer biblioteca

```bash
yarn add nome_do_package
```

### Criar migração

Criar um novo registro de edição ao banco de dados

```bash
php artisan make:migration nome_da_migração
```

### Migrar bancos de dados

Confirmar edições no banco de dados.

Rode sempre que criar novas [migrações](#criar-migração) ou [models](#criar-model) ou quando for trocar de banco de dados (ex.: MariaDB -> Postgres)

```bash
php artisan migrate
```

### Criar model

Lembre-se de rodar o [migrate](#migrar-bancos-de-dados) ao criar ou editar qualquer model

```bash
php artisan make:model Coiso
```

### Criar Controller

```bash
php artisan make:controller CoisoController
```

### Criar ServiceProvider

```bash
php artisan make:provider CoisoServiceProvider
```

### Criar Middleware

Agem entre as rotas e o usuário

Ordem dos eventos:
`Cliente -> Middleware -> Backend`

```bash
php artisan make:middleware CoisoMiddleware
```
