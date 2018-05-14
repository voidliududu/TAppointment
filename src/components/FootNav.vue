<template>
  <mu-paper>
    <mu-bottom-nav :value="bottomNav" @change="handleChange">
      <mu-bottom-nav-item value="me" title="我" to="/me" icon="perm_identity"/>
      <mu-bottom-nav-item value="appointment" title="预约" to="/appointment" icon="calendar_today"/>
      <mu-bottom-nav-item value="about" title="关于" icon="info"/>
    </mu-bottom-nav>
</mu-paper>
</template>

<script>
    export default {
        name: "foot-nav",

    data () {
    return {
      bottomNav: 'me'
    }
  },
  methods: {
    handleChange (val) {
      this.bottomNav = val
    }
  }
}
</script>

<style scoped>

</style>
