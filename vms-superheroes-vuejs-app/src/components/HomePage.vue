<template>
    <div class="home">
      <div class="container">
        <!-- <div class="mb-5">
          <label for="token" class="form-label">Token</label>
          <div class="input-group">
            <span class="input-group-text" id="token-data">Token</span>
            <input v-model="token" type="text" class="form-control" id="token" aria-describedby="token-data token-text">
          </div>
          <div class="form-text" id="token-text">Enter token.</div>
        </div> -->
        <div class="row">
          <div
            v-for="(comic, index) in comics"
            :key="`comic-${index}`"
            class="col-md-4 col-sm-6 col-xs-12 mb-3"
          >
            <CardComponent
              :title="comic.title"
              :thumbnailUrl="comic.thumbnail_url"
              :description="comic.description"
              :seriesName="comic.series_name"
            />
          </div>
      </div>
      </div>
    </div>
  </template>
  
  <script>
  import ComicService from '@/services/ComicService'
  import CardComponent from '@/components/CardComponent'

  export default {
    name: 'HomePage',
    components: {
      CardComponent
    },
    data() {
      return {
        token: "",
        comics: [],
      }
    },
    methods: {
      async fetchComics(params) {
        return await ComicService.getAll(params)
      },
    },
    mounted() {
      const response = this.fetchComics()
      response.then((data) => {
        this.comics = data
      })
    }
    // watch: {
    //   token: function(tokenVal) {
    //     if (tokenVal) {
    //       const response = this.fetchComics({foo_bar: tokenVal})
    //       response.then((data) => {
    //         this.comics = data
    //       })
    //     }
    //   }
    // }
  }
  </script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
  </style>
  