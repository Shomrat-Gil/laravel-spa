<template>
    <div class="app-container">
        <div title="App"  >
            <div slot="actions" class="nav-buttons">
                <router-link to="/" v-if="!auth.user.authenticated">
                    <a 
                        class="signin"  >
                            Sign-in
                    </a>
                </router-link>
                <a v-if="auth.user.authenticated" @click="auth.signout()"
                    class="signin"  >
                        Sign-out
                </a>
            </div>
        </div>
        
        <div id="content-alerts" class="row"  >
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >   
                 <ul class="alert-messages" >
                    <li v-for="message in showErrors" >   
                        <div v-text="message"   class="alert alert-warning"></div> 
                    </li>
                 </ul>
            </div>
        </div>
                              
        <div class="main-content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import auth from '../services/auth'
    import router from '../routes'

    export default {
        name: 'app',
        data() {
            return {
                auth,
                remove_nav_icon: true
            }
        },
        created() {
            this.$on('restrict-user', this.handleRestrict)
        },
        beforeDestroy() {
            this.$off('restrict-user', this.handleRestrict)
        },
        mounted() {

        },
        computed: {   
            showErrors: function(){
                var data = [];   
                //console.log('this.$root.errors');     
               // console.log(this.$root.errors);
                var item = this.$root.errors;
                for(var key in this.$root.errors) {  
                    var element = item[key]; 
                    if(!Array.isArray(element)){
                        // if its a string 
                        element = [element];
                    }
                    data = data.concat(element);
                } 
                return data;
            },  
        },
        methods: {
            handleRestrict(role) {
                let cb = () => {
                    if(this.auth.user.role != role && role != 'guest') {
                        router.push({ name: 'home' })
                    }
                }
                auth.check(role, cb)
            }
        }
    }
</script>
