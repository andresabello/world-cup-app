<template>
    <div class="container">
       <navigation>
           <div class="panel-body">
               <router-view></router-view>
           </div>
       </navigation>
    </div>
</template>


<script>

    import Nav from './pages/partials/Navigation'

    export default {
        mounted() {
            console.log('Only see this once logged in')
        },
        components: {
            navigation: Nav
        }
    }
</script>
