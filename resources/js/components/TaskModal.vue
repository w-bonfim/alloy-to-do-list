<template>
  <div class="modal-task" @click="closeOnBackdrop">
    <div class="container-modal" @click.stop>
      <div class="top-modal">
        <h3>{{ isEditing ? 'Editar tarefa' : 'Nova tarefa' }}</h3>
        <div @click="$emit('close')" class="close-modal">
          <div class="icon w-embed">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 7L7 17M7 7L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="content-modal">
        <TaskForm
          :initial-data="task"
          @submit="handleSubmit"
          @cancel="$emit('close')"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, defineProps, defineEmits } from 'vue'
import TaskForm from './TaskForm.vue'

const props = defineProps({
  task: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'save'])
const isEditing = computed(() => props.task !== null)

const closeOnBackdrop = (event) => {
  if (event.target === event.currentTarget) {
    emit('close')
  }
}

const handleSubmit = (formData) => {
  emit('save', formData)
}
</script>

<style scoped>
.modal-task {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  background-color: rgba(0, 0, 0, 0.8) !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  z-index: 9999 !important;
  visibility: visible !important;
  opacity: 1 !important;
}

.container-modal {
  background: white !important;
  border-radius: 8px !important;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
  max-width: 500px !important;
  width: 90% !important;
  max-height: 90vh !important;
  overflow-y: auto !important;
  position: relative !important;
  margin: auto !important;
}

.top-modal {
  display: flex !important;
  justify-content: space-between !important;
  align-items: center !important;
  padding: 20px !important;
  border-bottom: 1px solid #e0e0e0 !important;
  background: white !important;
}

.top-modal h3 {
  margin: 0 !important;
  font-size: 1.25rem !important;
  color: #333 !important;
}

.close-modal {
  cursor: pointer !important;
  padding: 8px !important;
  border-radius: 4px !important;
  transition: background-color 0.2s ease !important;
  background: #f5f5f5 !important;
  border: none !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

.close-modal:hover {
  background-color: #e0e0e0 !important;
}

.content-modal {
  padding: 0 !important;
  background: white !important;
}
</style>
