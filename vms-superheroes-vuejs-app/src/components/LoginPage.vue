<template>
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-12 col-md-6 offset-md-3">
        <div class="card shadow sm">
          <div class="card-body">
            <h1 class="text-center">Login</h1>
            <hr/>
            <form action="javascript:void(0)" class="row" method="post">
              <div class="form-group col-12 my-2">
                <label for="email" class="font-weight-bold">Email</label>
                <input type="text" v-model="auth.email" name="email" id="email" class="form-control">
              </div>
              <div class="form-group col-12 my-2">
                <label for="password" class="font-weight-bold">Password</label>
                <input type="password" v-model="auth.password" name="password" id="password" class="form-control">
              </div>
              <div class="col-12 mb-2 my-2">
                <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                    {{ processing ? "Please wait" : "Login" }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

// TODO:
const host = 'http://localhost'

export default {
  name:"login",
  data() {
    return {
      auth: {
        email: 'jem@yahoo.com',
        password: '123456'
      },
      processing: false
    }
  },
  methods: {
    async login() {
      this.processing = true
      axios.defaults.withCredentials = true
      axios.defaults.baseURL = 'http://localhost'
      await axios.get(`/sanctum/csrf-cookie`)
      await axios.post(`/login`, this.auth)
        .then(({data})=>{
          if (data.user) {
            localStorage.setItem('currentUser', JSON.stringify(data.user))
            this.$router.push({ name: 'home' })
          }
        }).catch((data) => {
          console.error(data)
        }).finally(() => {
          this.processing = false
        })
    },
  }
}
</script>