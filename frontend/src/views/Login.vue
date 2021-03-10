<template>
    <div class='h-screen flex justify-center items-center'>
        <div class='w-100'>
            <input type="email" name="email" id="email" class='input' placeholder="Email" v-model='email'>
            <input type="password" name="password" id="password" class='input' placeholder="Senha" v-model='password'>
            <button class='btn btn-primary' @click="login">Login</button>
        </div>
    </div>     
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                email: '',
                password: '',
                message: '',
            }
        },
        methods: {
            login() {
                this.$http.get('/sanctum/csrf-cookie')
                    .then(() => {
                        this.$http.post('/login', {
                            email: this.email,
                            password: this.password
                        })
                        .then(response => {
                            const user = response.data.user
                            this.$store.commit('setUser', user)
                            this.$router.push({ name: 'home'})
                        })
                        .catch(response => {
                            console.log(response);
                        })
                    });
            }
        },
        created() {
            if(this.$store.state.User.user) {
                this.$router.push({ name: 'home'})
            }
        },
    }
</script>

<style>
    
</style>