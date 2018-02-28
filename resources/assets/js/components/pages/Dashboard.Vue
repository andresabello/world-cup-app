<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                I am only visible once you log in. This is a VUW SPA. The login is handled by Laravel
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        mounted() {
            console.log('Only see this once logged in')
        }
    }
</script>
