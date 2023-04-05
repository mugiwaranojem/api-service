<template>
  <div class="card-component">
    <div class="card">
    <img :src="thumbnailUrl" class="card-img-top" alt="">
    <div class="card-body">
      <h5 class="primary-title"><a href="#">{{ seriesName }}</a></h5>
      <h5 class="secondary-title">{{ title }}</h5>
      <p class="card-text">
        {{ trimText }}
        <span v-if="description.length > maxLength">
          <a href="#">Find out more about(..)</a>
        </span>
      </p>
    </div>
  </div>
  </div>
</template>
<script>
export default {
  name: 'CardComponent',
  props: {
    title: String,
    thumbnailUrl: String,
    description: String,
    seriesName: String
  },
  data() {
    return {
      maxLength: 200
    }
  },
  computed: {
    trimText() {
      return this.description.length > this.maxLength ? this.description.substring(0, this.maxLength) : this.description;
    }
  }
}
</script>
<style scoped>
.primary-title {
  font-size: 13px;
}
.secondary-title {
  font-size: 16px;
  font-weight: 600;
  color: #333;
}
.card-text {
  font-size: 12px;
  color: #333;
}

a {
  text-decoration: none;
  color: #33C4F2;
  -webkit-transition: all ease 0.3s;
  -moz-transition: all ease 0.3s;
  -o-transition: all ease 0.3s;
  -ms-transition: all ease 0.3s;
  transition: all ease 0.3s;
  outline: none;
}
</style>