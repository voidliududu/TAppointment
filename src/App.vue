<template>
  <div id="app">
    <img src="./assets/logo.png">
    <router-view/>
    <foot-nav/>
  </div>
</template>

<script>
import FootNav from "./components/FootNav";

export default {
  components: {FootNav},
  name: 'App'
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
