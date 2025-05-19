<template>
  <nav class="d-flex flex-row bg-gradient">
    <div class="d-flex align-content-center ms-3 mt-3">
      <p class="text-white font-bold">
        Task Manager
      </p>
    </div> 
  </nav>
  <router-view/>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  background-color: navy;
  display: flex;

  p {
    font-size: x-large;
  }
}

nav a {
  font-weight: bold;
  color: white;
}

nav a.router-link-exact-active {
  color: aqua;
}
</style>
