
<template>
  <h1>{{ $route.params.id }}</h1>
</template>

<script>
export default {
  name: "VpisnaSluzbaProgramiUrejanje",
  data: function(router){
    return {}
  },
  created: function() {
    this.$http.get("/api/programs", {params: {}})
    console.log(this.$route.params);
  }
}

</script>
