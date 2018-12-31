<template>
    <header id="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 clearfix">
                  <ul class="social-media">
                      <li><a href="https://twitter.com/RBG_Victoria" target="_blank"><span class="icon icon-twitter-solid"></span></a></li>
                      <li><a href="https://www.facebook.com/BotanicGardensVictoria" target="_blank"><span class="icon icon-facebook-solid"></span></a></li>
                      <li><a href="https://instagram.com/royalbotanicgardensvic/" target="_blank"><span class="icon icon-instagram-solid"></span></a></li>
                  </ul>
                </div> <!-- /.col -->

                <nav class="navbar navbar-default">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="navbar-brand">
                            <a class="brand-rbg" href="http://www.rbg.vic.gov.au"><img src="https://vicflora.rbg.vic.gov.au/images/rbg-logo-with-text.png" alt=""/></a>
                            <a class="brand-vicflora" href="https://hortflora.rbg.vic.gov.au/">HortFlora</a>
                        </div>
                    </div>

                    <div id="navbar" class="navbar-collapse collapse">
                      <ul class="nav navbar-nav">
                        <li class="home-link">
                            <router-link :to="{ name: 'home' }"><span class="glyphicon glyphicon-home"></span></router-link>
                        </li>
                      </ul>
                      <div class="navbar-form navbar-right">
                      </div>
                  </div><!--/.navbar-collapse -->
                </nav>

                <div class="col-lg-12">
                    <div class="login">
<!--                        <router-link
                            :to="{ name: 'login' }"
                            v-if="!$store.state.auth"
                        >Log in</router-link>
                        <span v-else>
                            {{ $store.state.user.name }} |
                            <a @click="logout">Log out</a>
                            <form id="logout-form" action="/logout" method="POST" style="display: hidden;">
                                <input type="hidden" name="_token" :value="csrf_token"/>
                            </form>
                        </span>-->
                    </div>

                    <div id="header">
                        <div id="logo">
                            <a href='http://www.rbg.vic.gov.au'>
                                <img class="img-responsive" src="https://vicflora.rbg.vic.gov.au/images/rbg-logo-with-text" alt="" />
                            </a>
                        </div>
                        <div id="site-name">
                            <a href="http://reference.localhost">Bibliography</a>
                        </div>
                    </div>
                </div>

          </div><!--/.row -->
        </div>
    </header>
</template>

<script>
    let token = document.head.querySelector('meta[name="csrf-token"]');

    export default {
        data() {
            return {
                csrf_token: token.content
            }
        },
        methods: {
            logout(event) {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>
