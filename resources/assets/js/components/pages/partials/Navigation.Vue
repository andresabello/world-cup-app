<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <nav>
                <ul class="list-inline">
                    <li>
                        <router-link :to="{ name: 'home' }">Home</router-link>
                    </li>
                    <li class="pull-right">
                        <router-link :to="{ name: 'login' }">Login</router-link>
                    </li>                    <li class="pull-right">
                    <router-link :to="{ name: 'register' }">Register</router-link>
                </li>
                </ul>
            </nav>
        </div>
        <slot></slot>
    </div>
    <!--<nav class="navbar navbar-expand-md navbar-light navbar-laravel">-->
        <!--&lt;!&ndash;<div class="container">&ndash;&gt;-->
            <!--&lt;!&ndash;<a class="navbar-brand" href="{{ url('/') }}">&ndash;&gt;-->
                <!--&lt;!&ndash;{{ config('app.name', 'Laravel') }}&ndash;&gt;-->
            <!--&lt;!&ndash;</a>&ndash;&gt;-->
            <!--&lt;!&ndash;<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">&ndash;&gt;-->
                <!--&lt;!&ndash;<span class="navbar-toggler-icon"></span>&ndash;&gt;-->
            <!--&lt;!&ndash;</button>&ndash;&gt;-->

            <!--&lt;!&ndash;<div class="collapse navbar-collapse" id="navbarSupportedContent">&ndash;&gt;-->
                <!--&lt;!&ndash;&lt;!&ndash; Left Side Of Navbar &ndash;&gt;&ndash;&gt;-->
                <!--&lt;!&ndash;<ul class="navbar-nav mr-auto">&ndash;&gt;-->

                <!--&lt;!&ndash;</ul>&ndash;&gt;-->

                <!--&lt;!&ndash;&lt;!&ndash; Right Side Of Navbar &ndash;&gt;&ndash;&gt;-->
                <!--&lt;!&ndash;<ul class="navbar-nav ml-auto">&ndash;&gt;-->
                    <!--&lt;!&ndash;&lt;!&ndash; Authentication Links &ndash;&gt;&ndash;&gt;-->
                    <!--&lt;!&ndash;@guest&ndash;&gt;-->
                    <!--&lt;!&ndash;<li><a class="nav-link" href="{{ route('login') }}">Login</a></li>&ndash;&gt;-->
                    <!--&lt;!&ndash;<li><a class="nav-link" href="{{ route('register') }}">Register</a></li>&ndash;&gt;-->
                    <!--&lt;!&ndash;@else&ndash;&gt;-->
                    <!--&lt;!&ndash;<li class="nav-item dropdown">&ndash;&gt;-->
                        <!--&lt;!&ndash;<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">&ndash;&gt;-->
                            <!--&lt;!&ndash;{{ Auth::user()->name }} <span class="caret"></span>&ndash;&gt;-->
                        <!--&lt;!&ndash;</a>&ndash;&gt;-->
                        <!--&lt;!&ndash;<div class="dropdown-menu" aria-labelledby="navbarDropdown">&ndash;&gt;-->
                            <!--&lt;!&ndash;<a class="dropdown-item" href="{{ route('logout') }}"&ndash;&gt;-->
                               <!--&lt;!&ndash;onclick="event.preventDefault();&ndash;&gt;-->
                                                     <!--&lt;!&ndash;document.getElementById('logout-form').submit();">&ndash;&gt;-->
                                <!--&lt;!&ndash;Logout&ndash;&gt;-->
                            <!--&lt;!&ndash;</a>&ndash;&gt;-->

                            <!--&lt;!&ndash;<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">&ndash;&gt;-->
                                <!--&lt;!&ndash;@csrf&ndash;&gt;-->
                            <!--&lt;!&ndash;</form>&ndash;&gt;-->
                        <!--&lt;!&ndash;</div>&ndash;&gt;-->
                    <!--&lt;!&ndash;</li>&ndash;&gt;-->
                    <!--&lt;!&ndash;@endguest&ndash;&gt;-->
                <!--&lt;!&ndash;</ul>&ndash;&gt;-->
            <!--&lt;!&ndash;</div>&ndash;&gt;-->
        <!--&lt;!&ndash;</div>&ndash;&gt;-->
    <!--</nav>-->
</template>

<script>
    export default {
        mounted() {
            console.log('Only see this once logged in')
        }
    }
</script>
