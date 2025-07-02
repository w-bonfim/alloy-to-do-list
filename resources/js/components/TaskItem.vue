<template>
  <div class="task" :class="{ 'completed': task.completed }">
    <label class="w-checkbox checkbox-field">
      <div class="w-checkbox-input w-checkbox-input--inputType-custom checkbox margin-right-10"></div>
      <input
        type="checkbox"
        :checked="task.completed"
        @change="$emit('toggle', task.id)"
        style="opacity:0;position:absolute;z-index:-1"
      >
      <span
        class="checkbox-label w-form-label"
        :class="{ 'checked': task.completed }"
      >
        {{ task.name }}
      </span>
    </label>

    <div class="date-button margin-left-40">
      <div>{{ formatDate(task.due_date) }}</div>
    </div>

    <div v-if="task.description" class="task-details">
      <div>{{ task.description }}</div>
    </div>

    <div class="task-actions">
      <div
        @click="$emit('edit', task)"
        class="edit-task margin-right-10"
      >
        <div class="button outlined rounded small">
          <div class="icon w-embed">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13M18.5 2.5C18.8978 2.10217 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10217 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10217 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
      </div>

      <div
        @click="$emit('delete', task.id)"
      >
        <div class="button outlined rounded small">
          <div class="icon w-embed">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  task: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['toggle', 'delete', 'edit'])

const formatDate = (date) => {
  if (!date) return 'Sem data'

  const taskDate = new Date(date)
  const today = new Date()
  const tomorrow = new Date(today)
  tomorrow.setDate(tomorrow.getDate() + 1)

  // Normalizar as datas para comparação (apenas dia/mês/ano)
  const normalizeDate = (d) => new Date(d.getFullYear(), d.getMonth(), d.getDate())

  const normalizedTaskDate = normalizeDate(taskDate)
  const normalizedToday = normalizeDate(today)
  const normalizedTomorrow = normalizeDate(tomorrow)

  if (normalizedTaskDate.getTime() === normalizedToday.getTime()) {
    return 'Hoje'
  } else if (normalizedTaskDate.getTime() === normalizedTomorrow.getTime()) {
    return 'Amanhã'
  } else {
    return taskDate.toLocaleDateString('pt-BR', {
      weekday: 'short',
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    })
  }
}
</script>

<style scoped>
.task {
  display: flex;
  align-items: center;
  padding: 10px 0;
  border-bottom: 1px solid #f0f0f0;
  transition: opacity 0.2s ease;
}

.task.completed {
  opacity: 0.6;
}

.task.completed .checkbox-label {
  text-decoration: line-through;
}

.task-actions {
  display: flex;
  margin-left: auto;
  gap: 5px;
}

.edit-task,
.remove-task {
  cursor: pointer;
}

.button {
  cursor: pointer;
  transition: all 0.2s ease;
}

.button:hover {
  opacity: 0.8;
}

.task-details {
  font-size: 0.9em;
  color: #666;
  margin-left: 10px;
}

.date-button {
  font-size: 0.85em;
  color: #888;
}
</style>
