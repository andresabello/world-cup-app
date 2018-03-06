<template>
    
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: 'settings',
        computed: mapGetters({
            token: 'token',
        }),
        beforeRouteEnter (to, from, next) {
            next(vm => {
                if (typeof vm.token !== 'undefined' &&  vm.token.length > 10){
                    if (typeof vm.token !== 'undefined' &&  vm.token.length > 10){
                        next('login')
                    }
                    next()

                }
            })
        }
    }
</script>

<style scoped>

</style>