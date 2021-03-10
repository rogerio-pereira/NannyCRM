<template>
    <div id="app">
        <div class='nav'>
            <div class='w-1/2'>
                <router-link to='/'>NannyCRM</router-link>
            </div>
            <!--Autenticated Menu-->
            <div class='w-1/2 text-right' v-if='this.$store.state.User.user'>
                <a href='/' @click.prevent.stop='logout()'>Logout</a>
            </div>
            <!--Guest Menu-->
            <div class='w-1/2 text-right' v-if='!this.$store.state.User.user'>
                <router-link to='/login'>Login</router-link>
            </div>
        </div>
        <div class='view'>
            <router-view/>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Exemple',
        created(){
            if(!this.$store.state.User.user) {
                this.$router.push({ name: 'login'})
            }
        },
        methods: {
            logout() {
                console.log('logout')
                this.$store.commit('setUser', null)
                this.$http.post('/logout', {})
                    .then(() => {
                        document.cookie = 'XSRF-TOKEN=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'
                        document.cookie = 'nannycrm_session=; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'
                        window.location = "/login";
                    })
                    .catch(response => {
                        console.log(response)
                    })
            }
        }
    }
</script>

<style lang="scss">
</style>
