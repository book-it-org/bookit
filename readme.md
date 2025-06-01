# Bookit

Um marketplace de livros usados pensado para as cidades do noroeste capixaba.

## Sumário

- [Tarefas](#tarefas)
- [Requisitos](#requisitos)
- [Workflow](#workflow)
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

## Workflow

O projeto segue o modelo de desenvolvimento **Trunk-Based Development (TBD)**

- Temos **uma única branch principal (`main`)**
- Para qualquer mudança crítica* será criado um novo **branch curto e específico de vida curta** para a implementação 
- Faremos o uso de [toggles](#toggles) durante o desenvolvimento
- Iremos excluir qualquer branch que já tenha sido implementado à **main** após algumas horas

\* Uma mudança crítica é qualquer mudança que, ao ser implementada, terá resultados significativos na versão final do sistema. Por exemplo, mudar o texto de algum componente ou a documentação do `README.md` **não seriam** mudanças críticas, mas **trocar ou adicionar lógica** em algum componente ou controller sim.

### Branches

| Tipo                 | Prefixo     | Exemplo                                      |
|----------------------|-------------|----------------------------------------------|
| Funcionalidade nova  | `feature/`  | `feature/autenticacao`, `feature/layout-principal` |
| Correção de bug      | `fix/`      | `fix/erro-login`, `fix/ajuste-layout`        |
| Infra/configuração   | `chore/`    | `chore/instalar-laravel-pennant`             |
| CI/CD                | `ci/`       | `ci/ajustar-workflow-deploy`                 |
| Documentação         | `docs/`     | `docs/atualizar-readme`                      |

### Regras de commit

Os commits devem ser **curtos, claros e descritivos**, seguindo este padrão:

```bash
<tipo>: <descrição curta>
```

### Regras de commit

| Tipo       | Descrição                                      | Exemplo                                      |
|------------|------------------------------------------------|----------------------------------------------|
| `feat`     | Nova funcionalidade                             | `feat: implementar autenticação` |
| `fix`      | Correção de bug                                | `fix: corrigir erro de validação no login`   |
| `docs`     | Mudança na documentação                        | `docs: atualizar instruções no README`       |
| `style`    | Alterações visuais ou de formatação (sem lógica) | `style: ajustar indentação do componente`    |
| `refactor` | Melhoria interna do código (sem nova feature)   | `refactor: simplificar lógica do controller` |
| `test`     | Adição ou alteração de testes                   | `test: adicionar testes para autenticação`   |
| `chore`    | Tarefa de manutenção geral                      | `chore: atualizar dependências`              |
| `ci`       | Ajustes em pipelines ou automações              | `ci: corrigir workflow do GitHub Actions`    |


### Toggles

Durante o desenvolvimento, utilizamos **feature toggles** (também chamadas de *feature flags*), via [Laravel Pennant](https://laravel.com/docs/pennant), para controlar o acesso a funcionalidades em desenvolvimento ou testes, evitando a criação de **branchs de vida longa** e sem deixar **código incompleto** exposto, em "funcionamento".

#### Benefícios

- Permitir deploys frequentes, mesmo com funcionalidades incompletas
- Ativar/desativar recursos rapidamente sem alterar o código
- Reduzir a necessidade de múltiplas branches
- Facilitar testes

#### Como usar

##### Criando a flag

```bash
php artisan pennant:define novaFlag
```

Isso irá criar um arquivo em `app/Features/novaFlag.php` de conteúdo 

```php
use Laravel\Pennant\Feature;

return function () {
    return true; // esse valor define se a flag está ativa ou não
};
```

##### Usando no backend

Para usar diretamente no backend

```php
use Laravel\Pennant\Feature;

if (Feature::active('novaFlag')) {
    // novo fluxo utilizando a nova feature
} else {
    // fluxo antigo
}
```


Você pode ativar ou desativar a flag especificamente para um usuário ou ambiente

```php
Feature::for($user)->activate('novaFlag');
```

##### Usando no frontend

Para enviar quais flags estão ativas ao frontend

```php
use Inertia\Inertia;
use Laravel\Pennant\Feature;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

    Inertia::share([
        'features' => function () {
            return [
                'flag1' => Feature::active('flag1'),
                'flag2' => Feature::active('flag2'),
                'flag3' => Feature::active('flag3'),
                'novaFlag' => Feature::active('novaFlag'),
            ];
        },
    ]);

    }
}
```

Acessando as flags a partir do composable `usePage` do `@inertiajs/vue3`

```vue
<template>
  <ComponenteNovo v-if="features.novaFLag" />
  <ComponenteAntigo v-else />
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const { features } = page.props
</script>
```

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

### Criar nova Feature Flag

```bash
php artisan pennant:define novaFlag
```

### Criar migração

Criar um novo registro de edição ao banco de dados

```bash
php artisan make:migration nome_da_migração
```

### Migrar bancos de dados

Confirmar edições no banco de dados.

Rode sempre que criar novas [migrações](#criar-migração) ou [models](#criar-model) ou quando for trocar de banco de dados (ex.: `MariaDB -> Postgres`)

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
