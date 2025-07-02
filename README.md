# Alloy To-Do List

Este projeto foi criado para o teste técnico da Alloy. É uma aplicação de lista de tarefas (To-Do List) com backend em Laravel 12 e frontend em Vue.js 3, incluindo funcionalidades como cache, soft delete, filas com jobs e integração entre frontend e backend.

---

## Stack Utilizada

### Backend
- Laravel 12
- PHP 8.2
- SQLite
- Filas com Jobs (Queue)
- Cache com tags
- Soft Deletes

### Frontend
- Vue.js 3.4
- Pinia 2.1
- TailwindCSS 4.0
- Vite 6.3

---

## Instalação

### Backend (Laravel)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
php artisan db:seed
```

#### Para rodar as filas (jobs):
```bash
php artisan queue:work
```

### Frontend (Vue + Vite)

```bash
cd resources/js
npm install
npm run dev
```

---

## Funcionalidades Implementadas

- CRUD completo de tarefas
- Marcar tarefa como finalizada/não finalizada
- Soft delete (exclusão lógica)
- Exclusão definitiva com job após 10 minutos da finalização
- Cache de listagem e visualização de tarefas com tags e invalidação automática
- Layout baseado no design Webflow (pasta public/webflow)
- Integração completa Laravel ↔ Vue.js
- Componentização com Vue 3 + Pinia

---

## Estrutura do Projeto

### Laravel
```
app/
├── Http/Controllers/     # API Controllers
├── Jobs/                 # Job DeleteCompletedTask
├── Models/               # Task model
├── Services/             # TaskService para lógica de negócio e cache
routes/
└── api.php               # Rotas da API
```

### Vue
```
resources/js/
├── components/
│   ├── TaskList.vue      # Lista de tarefas
│   ├── TaskItem.vue      # Tarefa individual
│   ├── TaskModal.vue     # Modal de criação/edição
│   └── TaskForm.vue      # Formulário da tarefa
├── stores/
│   └── taskStore.js      # Store Pinia
├── services/
│   └── taskService.js    # Comunicação com API Laravel
```

