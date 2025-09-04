# 📝 API de Tarefas - Laravel

Uma API REST simples e robusta para gerenciamento de tarefas, construída com **Laravel 12** e autenticação **Laravel Sanctum**.

## 🚀 Tecnologias Utilizadas

- **Laravel 12** - Framework PHP
- **Laravel Sanctum** - Autenticação de API
- **MySQL** - Banco de dados
- **PHP 8.3+** - Linguagem de programação

## ⚡ Funcionalidades

- ✅ Autenticação segura com tokens
- ✅ CRUD completo de tarefas
- ✅ Filtragem por status
- ✅ Paginação automática
- ✅ Validação robusta de dados
- ✅ Tratamento de erros padronizado
- ✅ Autorização por usuário

## 📋 Pré-requisitos

- PHP 8.3 ou superior
- Composer
- MySQL ou PostgreSQL

## 🔧 Instalação e Configuração

### 1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/api-tarefas.git
cd api-tarefas
```

### 2. Instale as dependências
```bash
composer install
```

### 3. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o banco de dados
Edite o arquivo `.env` com suas credenciais:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_tarefas
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Execute as migrações
```bash
php artisan migrate
```

### 7. Inicie o servidor
```bash
php artisan serve
```

A API estará disponível em: `http://localhost:8000`

## 🔐 Autenticação

Esta API utiliza **Laravel Sanctum** para autenticação baseada em tokens.

### Registro de Usuário
```http
POST /api/register
Content-Type: application/json

{
    "name": "João Silva",
    "email": "joao@exemplo.com",
    "password": "senha123",
    "password_confirmation": "senha123"
}
```

### Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "joao@exemplo.com",
    "password": "senha123"
}
```

**Resposta:**
```json
{
    "success": true,
    "message": "Login realizado com sucesso",
    "data": {
        "user": {
            "id": 1,
            "name": "João Silva",
            "email": "joao@exemplo.com"
        },
        "token": "1|abc123def456..."
    }
}
```

### Logout
```http
POST /api/logout
Authorization: Bearer {seu-token}
```

## 📚 Endpoints da API

### Base URL
```
http://localhost:8000/api
```

Todas as rotas de tarefas requerem autenticação. Inclua o header:
```
Authorization: Bearer {seu-token}
```

### Tarefas

#### Listar Tarefas
```http
GET /api/tasks
```

**Parâmetros de Query (opcionais):**
- `status`: `pending`, `in_progress`, `completed`
- `page`: número da página (padrão: 1)
- `per_page`: itens por página (padrão: 10, máx: 100)

**Exemplo:**
```http
GET /api/tasks?status=pending&page=1&per_page=5
```

**Resposta:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Estudar Laravel",
            "description": "Aprender sobre APIs REST",
            "status": "pending",
            "user_id": 1,
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        }
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 3,
        "per_page": 5,
        "total": 15
    }
}
```

#### Criar Tarefa
```http
POST /api/tasks
Content-Type: application/json

{
    "title": "Nova Tarefa",
    "description": "Descrição da tarefa",
    "status": "pending"
}
```

**Campos:**
- `title` (obrigatório): string, 3-255 caracteres
- `description` (opcional): string, máx 1000 caracteres  
- `status` (opcional): `pending`, `in_progress`, `completed` (padrão: `pending`)

#### Visualizar Tarefa
```http
GET /api/tasks/{id}
```

#### Atualizar Tarefa
```http
PUT /api/tasks/{id}
Content-Type: application/json

{
    "title": "Título Atualizado",
    "status": "completed"
}
```

**Campos (todos opcionais):**
- `title`: string, 3-255 caracteres
- `description`: string, máx 1000 caracteres
- `status`: `pending`, `in_progress`, `completed`

#### Deletar Tarefa
```http
DELETE /api/tasks/{id}
```

## 📊 Status das Tarefas

- `pending` - Pendente
- `in_progress` - Em Progresso  
- `completed` - Concluída

## ⚠️ Tratamento de Erros

A API retorna erros em formato JSON padronizado:

### Erro de Validação (422)
```json
{
    "success": false,
    "message": "Dados de entrada inválidos",
    "errors": {
        "title": ["O título é obrigatório."]
    }
}
```

### Erro de Autorização (403)
```json
{
    "success": false,
    "message": "Acesso negado",
    "error": "Você não tem permissão para acessar este recurso"
}
```

### Erro de Autenticação (401)
```json
{
    "success": false,
    "message": "Não autenticado",
    "error": "Token de acesso inválido ou expirado"
}
```

### Recurso Não Encontrado (404)
```json
{
    "success": false,
    "message": "Recurso não encontrado",
    "error": "O recurso solicitado não existe"
}
```

## 🧪 Testando a API

### Usando cURL

**1. Registrar usuário:**
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Teste User",
    "email": "teste@exemplo.com",
    "password": "senha123",
    "password_confirmation": "senha123"
  }'
```

**2. Fazer login e obter token:**
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "teste@exemplo.com",
    "password": "senha123"
  }'
```

**3. Criar tarefa:**
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer SEU_TOKEN_AQUI" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Minha primeira tarefa",
    "description": "Testando a API",
    "status": "pending"
  }'
```

**4. Listar tarefas:**
```bash
curl -X GET "http://localhost:8000/api/tasks" \
  -H "Authorization: Bearer SEU_TOKEN_AQUI"
```

### Usando Postman/Insomnia

1. Importe a collection (se disponível)
2. Configure a variável de ambiente `token` após o login
3. Teste todos os endpoints

## 📁 Estrutura do Projeto

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   └── TaskController.php
│   │   └── Requests/
│   │       ├── StoreTaskRequest.php
│   │       └── UpdateTaskRequest.php
│   ├── Models/
│   │   ├── Task.php
│   │   └── User.php
│   └── Policies/
│       └── TaskPolicy.php
├── database/
│   └── migrations/
├── routes/
│   └── api.php
└── README.md
```
