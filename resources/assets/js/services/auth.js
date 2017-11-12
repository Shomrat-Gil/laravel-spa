import router from '../routes'
import {profile} from '../config'
import {USER_RESOURCE, USER_AUTHENTICATE} from '../api_routes'

export default {
	user: {
		authenticated: false,
		profile,
		role: null
	},
	check(role, callback) {
        if (role == 'guest') {
            if(typeof callback == 'function') {
                callback()
            }
            return
        }
        // alert('2- '+sessionStorage.getItem('id_token'));
        // alert('3- '+Vue.http.headers.common['Authorization']);
        if (sessionStorage.getItem('id_token') != null) {
            Vue.http.get(
                USER_RESOURCE,
            ).then(response => {
                this.user.authenticated = true
                this.user.profile = response.data.user
                this.user.role = response.data.role

                if(typeof callback == 'function') {
                    callback()
                } else {
                    if (
                        typeof this.user.role != 'undefined' &&
                        typeof role != 'undefined' && 
                        role != this.user.role
                    ) 
                    {     
                        router.push({
                            //name: `${this.user.role}`
                            name: this.user.role
                        })
                    }
                }

            }, response => {
                this.signout()
            })
            
            return
        } 

        router.push({ name: 'home' })
    },
    signin(context, email, password, callback) {   
        Vue.http.patch(
            USER_AUTHENTICATE,
            {
                email: email,
                password: password
            }
        ).then(response => {
            console.log('auth-ok');
            console.log(response.data);
            //context.error = false
            this.setToken(response.data.token)

            this.user.authenticated = true
            this.user.profile = response.data.user
            this.user.role = response.data.role 
            router.push({
                //name: `${this.user.role}`
                name: this.user.role
            })
        }, response => {
            
            console.log('auth-fail');   
            console.log(response.data);
            //context.error_message = response.data
            //context.error = true
            context.$root.errors = response.data
        })  
    },
    signout() {
        sessionStorage.removeItem('id_token')
        this.user.authenticated = false
        this.user.profile = profile
        this.user.role = null

        router.push({
            name: 'home'
        })
    },
    setToken(token) {    // alert('1- '+token);
        sessionStorage.setItem('id_token', token)    
        //Vue.http.headers.common['Authorization'] = 'BuildingCast-' + sessionStorage.getItem('id_token')
        Vue.http.headers.common['Authorization'] = 'bearer ' + token;
    }
}