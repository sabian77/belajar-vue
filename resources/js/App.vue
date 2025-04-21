<script setup>
  import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
    <div>
      <HelloWorld msg="You did it!" />

      <nav>
        <RouterLink to="/">Home</RouterLink>
        <RouterLink to="/login">Login</RouterLink>
      </nav>
    </div>
  </header>

  <RouterView />
</template>

