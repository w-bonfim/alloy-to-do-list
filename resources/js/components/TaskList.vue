<template>
  <div class="content-tasks">
    <div class="header">
      <h2>Tarefas</h2>
      <div
        @click="openTaskModal()"
        class="button rounded"
      >
        <div class="icon w-embed">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
        </div>
      </div>
    </div>

    <div class="tasks">
      <div class="form-fields no-space-top w-form">
        <div class="block-tasks">
          <TaskItem
            v-for="task in tasks"
            :key="task.id"
            :task="task"
            @toggle="toggleTask"
            @delete="deleteTask"
            @edit="openTaskModal"
          />

          <div v-if="loading" class="loading">
            Carregando...
          </div>

          <div v-if="!loading && tasks.length === 0" class="empty-state">
            Nenhuma tarefa encontrada
          </div>
        </div>
      </div>
    </div>

    <div class="footer">
      <div>Alloy</div>
    </div>

    <TaskModal
      v-if="showModal"
      :task="selectedTask"
      @close="closeTaskModal"
      @save="saveTask"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useTaskStore } from '@/stores/taskStore'
import TaskItem from './TaskItem.vue'
import TaskModal from './TaskModal.vue'

const taskStore = useTaskStore()

// Estado local
const showModal = ref(false)
const selectedTask = ref(null)

// Estados computados do store
const tasks = computed(() => taskStore.tasks)
const loading = computed(() => taskStore.loading)

const openTaskModal = (task = null) => {
  selectedTask.value = task
  showModal.value = true
}

const closeTaskModal = () => {
  showModal.value = false
  selectedTask.value = null
}

const saveTask = async (taskData) => {
  try {
    if (selectedTask.value) {
      await taskStore.updateTask(selectedTask.value.id, taskData)
    } else {
      await taskStore.createTask(taskData)
    }
    closeTaskModal()
  } catch (error) {
    console.error('Erro ao salvar tarefa:', error)
  }
}

const toggleTask = async (taskId) => {
  try {
    await taskStore.toggleTask(taskId)
  } catch (error) {
    console.error('Erro ao alterar status da tarefa:', error)
  }
}

const deleteTask = async (taskId) => {
  try {
    if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
      await taskStore.deleteTask(taskId)
    }
  } catch (error) {
    console.error('Erro ao excluir tarefa:', error)
  }
}

// load tarefas montar o componente
onMounted(() => {
  taskStore.fetchTasks()
})
</script>

<style scoped>
.loading {
  text-align: center;
  padding: 20px;
  color: #666;
}

.empty-state {
  text-align: center;
  padding: 40px 20px;
  color: #666;
  font-style: italic;
}

.button {
  cursor: pointer;
  transition: all 0.2s ease;
}

.button:hover {
  opacity: 0.8;
}
</style>
