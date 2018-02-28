<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1 class="text-center">Login</h1>
                        </div>
                        <p v-if="$route.query.redirect">
                            You need to login first.
                        </p>
                        <pi-form :fields="fields" action="/register"></pi-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PiForm from '../utilities/PiForm'
    import {mapGetters} from 'vuex'

    export default {
        computed: mapGetters({
            fields: 'loginForm',
            action: 'loginAction'
        }),
        mounted() {

        },
        methods: {
            login () {
                auth.login(this.email, this.pass, loggedIn => {
                    if (!loggedIn) {
                        this.error = true
                    } else {
                        this.$router.replace(this.$route.query.redirect || '/')
                    }
                })
            }
        },
        components: {
            "pi-form": PiForm
        }
    }
</script>