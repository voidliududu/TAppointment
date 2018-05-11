<template>
    <mu-paper>
  <mu-row>
      <mu-col width="33">
          <div>
            <mu-avatar slot="left" :src="userhead" />
          </div>
      </mu-col>
      <mu-col width="66">
          <div id="username">{{username}}</div>
          <div id="userSchool">{{userSchool}}</div>
      </mu-col>
  </mu-row>
        </mu-paper>
</template>
<script>
    export default {
        name: "HeadInfo",
        props:['userhead','username','userSchool'],
        data: function () {
            return {
            }
        }
    }
</script>

<style scoped>

</style>