import { defineStore } from 'pinia'
import { taskService } from '@/services/taskService'

export const useTaskStore = defineStore('tasks', {
  state: () => ({
    tasks: [],
    loading: false,
    error: null
  }),

  actions: {
    // Buscar todas as tarefas
    async fetchTasks() {
      this.loading = true
      try {
        const response = await taskService.getTasks()
        this.tasks = response.data
      } catch (error) {
        this.error = 'Erro ao carregar tarefas'
        console.error(error)
      } finally {
        this.loading = false
      }
    },

    // Criar nova tarefa
    async createTask(taskData) {
      try {
        const response = await taskService.createTask(taskData)
        this.tasks.push(response.data)
        return response.data
      } catch (error) {
        console.error('Erro ao criar tarefa:', error)
        throw error
      }
    },

    // Atualizar tarefa
    async updateTask(taskId, taskData) {
      try {
        const response = await taskService.updateTask(taskId, taskData)
        const index = this.tasks.findIndex(task => task.id === taskId)
        if (index !== -1) {
          this.tasks[index] = response.data
        }
        return response.data
      } catch (error) {
        console.error('Erro ao atualizar tarefa:', error)
        throw error
      }
    },

    // Excluir tarefa
    async deleteTask(taskId) {
      try {
        await taskService.deleteTask(taskId)
        this.tasks = this.tasks.filter(task => task.id !== taskId)
      } catch (error) {
        console.error('Erro ao excluir tarefa:', error)
        throw error
      }
    },

    // Alternar status da tarefa
    async toggleTask(taskId) {
      const task = this.tasks.find(task => task.id === taskId)
      if (!task) return

      try {
        await this.updateTask(taskId, { ...task, completed: !task.completed })
      } catch (error) {
        console.error('Erro ao alterar status:', error)
        throw error
      }
    }
  }
})
