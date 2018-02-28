<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1 class="text-center">Register</h1>
                        </div>
                        <pi-form :fields="fields" :action="action"></pi-form>
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
            fields: 'registerForm',
            action: 'registerAction'
        }),
        methods: {},
        components: {
            "pi-form": PiForm
        }
    }
</script>