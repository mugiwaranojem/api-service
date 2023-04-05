<template>
    <div class="home">
      <h1>HOME</h1>
    </div>
  </template>
  
  <script>
  import MarvelAuthorService from '@/services/MarvelAuthorService'

  export default {
    name: 'HomePage',
    props: {
      msg: String
    },
    methods: {
      async fetchAuthors() {
        return await MarvelAuthorService.getAll()
      },
    },
    mounted() {
      this.fetchAuthors();
    }
  }
  </script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
  h3 {
    margin: 40px 0 0;
  }
  ul {
    list-style-type: none;
    padding: 0;
  }
  li {
    display: inline-block;
    margin: 0 10px;
  }
  a {
    color: #42b983;
  }
  </style>
  