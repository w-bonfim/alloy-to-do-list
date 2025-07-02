import axios from 'axios'

// Configuração base do axios
const api = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  }
})

// Adicionar token CSRF nas requisições
api.interceptors.request.use((config) => {
  const token = document.querySelector('meta[name="csrf-token"]')
  if (token) {
    config.headers['X-CSRF-TOKEN'] = token.getAttribute('content')
  }
  return config
})

// Serviço de tarefas
export const taskService = {
  // Buscar todas as tarefas
  async getTasks() {
    const response = await api.get('/tasks')
    return response
  },

  // Buscar tarefa por ID
  async getTask(id) {
    const response = await api.get(`/tasks/${id}`)
    return response
  },

  // Criar nova tarefa
  async createTask(taskData) {
    const response = await api.post('/tasks', taskData)
    return response
  },

  // Atualizar tarefa
  async updateTask(id, taskData) {
    const response = await api.put(`/tasks/${id}`, taskData)
    return response
  },

  // Excluir tarefa
  async deleteTask(id) {
    const response = await api.delete(`/tasks/${id}`)
    return response
  },

  // Alternar status da tarefa
  async toggleTask(id) {
    const response = await api.patch(`/tasks/${id}/toggle`)
    return response
  }
}
