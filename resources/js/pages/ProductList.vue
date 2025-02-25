<template>
    <div id="app">
      <h1>Hello from!</h1>
      <Button label="Click me!" />
    </div>

  </template>
  
  <script>
  import Button from 'primevue/button';

  export default {
    name: 'ProductList',
    components: {
      Button
    }
  };
  </script>
  
  <style scoped>
  h1 {
    color: blue;
  }
  </style>
  