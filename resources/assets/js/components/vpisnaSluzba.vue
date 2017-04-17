<template>

  <router-view></router-view>

</template>

<script>


  export default {
    name: 'vpisnaSluzba',
    data: function(router) {
        return {
          section: 'Vpisna Sluzba'
        }
    },
    mounted() {
      console.log('referent dashboard mounted.');
      //this.$router.push('404');
      //console.log("should redirect")
    }
  }
</script>
