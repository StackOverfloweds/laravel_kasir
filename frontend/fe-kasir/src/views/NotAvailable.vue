<!-- src/views/NotAvailable.vue -->
<template>
    <div class="not-available">
      <h1>Sorry, this page is not available.</h1>
      <p>We could not find the page you're looking for. You will be redirected to the login page shortly.</p>
    </div>
  </template>
  
  <script>
  export default {
    name: "NotAvailable",
    mounted() {
      // Redirect to login page after 3 seconds
      setTimeout(() => {
        this.$router.push('/');
      }, 3000);
    }
  }
  </script>
  
  <style scoped>
  .not-available {
    text-align: center;
    padding: 50px;
  }
  </style>
  