<script setup>
import TaskList from '@/components/TaskList.vue'
</script>

<template>
  <div id="app">
    <TaskList />
  </div>
</template>

<style>
@import url('../css/normalize.css');
@import url('../css/webflow.css');
@import url('../css/alloy-tests.webflow.css');

#app {
  font-family: 'Roboto', sans-serif;
  min-height: 100vh;
  background-color: #f8f9fa;
}

body {
  margin: 0;
  padding: 0;
}
</style>
