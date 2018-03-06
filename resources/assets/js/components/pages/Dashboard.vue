<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                User dashboard. Hello User name
            </div>
        </div>
    </div>
</template>


<script>
    import {mapGetters} from 'vuex'

    export default {
        computed: mapGetters({
            token: 'token',
        }),
        data(){
            return {}
        },
        mounted() {
            //get the user using the token that should be store in localStorage
        },
        beforeRouteEnter (to, from, next) {
            next(vm => {
                if (typeof vm.token !== 'undefined' &&  vm.token.length > 10){
                    next('login')
                }
                next()
            })
        }
    }
</script>
