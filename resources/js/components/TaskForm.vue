<template>
  <form @submit.prevent="handleSubmit" class="task-form">
    <div class="content-modal">
      <div class="form-fields w-form">
        <div class="block-fields-form">
          <div class="input-wrap no-margin-bottom">
            <input
              v-model="formData.name"
              class="input w-input"
              maxlength="256"
              type="text"
              id="task-title"
              required
              :class="{ 'filled': formData.name }"
            >
            <label for="task-title" class="field-label">Título</label>
          </div>

          <div class="input-wrap no-margin-bottom">
            <textarea
              v-model="formData.description"
              class="input w-input"
              id="task-details"
              rows="3"
              :class="{ 'filled': formData.description }"
            ></textarea>
            <label for="task-details" class="field-label">Detalhes</label>
          </div>

          <div class="input-wrap no-margin-bottom">
            <input
              v-model="formData.due_date"
              class="input w-input"
              type="date"
              id="task-date"
              :class="{ 'filled': formData.due_date }"
            >
            <label for="task-date" class="field-label">Data</label>
          </div>

          <div v-if="isEditing" class="input-wrap no-margin-bottom">
            <label class="w-checkbox checkbox-field">
              <input
                v-model="formData.completed"
                type="checkbox"
                class="w-checkbox-input"
              >
              <span class="checkbox-label w-form-label">
                Tarefa concluída
              </span>
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="bottom-modal">
      <div class="flex-block-horizontal-right-align">
        <button
          type="button"
          @click="$emit('cancel')"
          class="button outlined rounded"
        >
          <div>Fechar</div>
        </button>
        <button
          type="submit"
          class="button rounded"
          :disabled="!formData.name.trim()"
        >
          <div>{{ isEditing ? 'Atualizar' : 'Salvar' }}</div>
        </button>
      </div>
    </div>
  </form>
</template>

<script setup>
import { ref, watch, computed, defineProps, defineEmits } from 'vue'

const props = defineProps({
  initialData: {
    type: Object,
    default: null
  }
})
const emit = defineEmits(['submit', 'cancel'])

const formData = ref({
  name: '',
  description: '',
  due_date: '',
  completed: false
})

const isEditing = computed(() => props.initialData !== null)

watch(() => props.initialData, (newData) => {
  if (newData) {
    formData.value = {
      name: newData.name || '',
      description: newData.description || '',
      due_date: newData.due_date || '',
      completed: newData.completed || false
    }
  } else {
    // Reset para nova tarefa
    formData.value = {
      name: '',
      description: '',
      due_date: '',
      completed: false
    }
  }
}, { immediate: true })


const handleSubmit = () => {
  if (!formData.value.name.trim()) {
    return
  }

  emit('submit', { ...formData.value })
}
</script>

<style scoped>
.task-form {
  display: flex;
  flex-direction: column;
}

.content-modal {
  padding: 20px;
}

.block-fields-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.input-wrap {
  position: relative;
}

.input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
  transition: border-color 0.2s ease;
}

.input:focus {
  outline: none;
  border-color: #007bff;
}

.field-label {
  position: absolute;
  left: 12px;
  top: 12px;
  color: #666;
  font-size: 16px;
  pointer-events: none;
  transition: all 0.2s ease;
  background: white;
  padding: 0 4px;
}

.input:focus + .field-label,
.input.filled + .field-label,
.input:valid + .field-label {
  top: -10px;
  font-size: 14px;
  color: #007bff;
}

textarea.input {
  resize: vertical;
  min-height: 80px;
}

.checkbox-field {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.w-checkbox-input {
  margin-right: 8px;
}

.bottom-modal {
  padding: 20px;
  border-top: 1px solid #e0e0e0;
  background-color: #f9f9f9;
}

.flex-block-horizontal-right-align {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
}

.button {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.2s ease;
}

.button.outlined {
  background: transparent;
  border: 1px solid #ddd;
  color: #666;
}

.button.outlined:hover {
  background-color: #f5f5f5;
}

.button.rounded {
  background-color: #007bff;
  color: white;
}

.button.rounded:hover:not(:disabled) {
  background-color: #0056b3;
}

.button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
