<template>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container dashboard">
          <div class="row">
            <div class="col d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                </div>
                <div class="card-body">
                  <form @submit.prevent="login">
                    <div class="mb-3">
                      <input type="text" v-model="username" class="form-control form-control-lg" placeholder="Username"
                        required>
                    </div>
                    <div class="mb-3">
                      <input type="password" v-model="password" class="form-control form-control-lg"
                        placeholder="Password" required>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>

export default {
  name: 'LoginPage',
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    async login() {
      const success = await this.$store.dispatch('login', {
        username: this.username,
        password: this.password
      });
      if (success) {
        this.$router.push('/dashboard');
      }
    }


  }
}
</script>