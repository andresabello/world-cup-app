export default class Auth {

    constructor() {
        this.storage = localStorage
        this.loginUrl = '/login'
        this.logoutUrl = '/logout'
        this.registerUrl = '/register'
    }

    register(form, url) {
        this.submit(form,`${url}/${this.registerUrl}`,form.data)
    }

    login(form, url) {
        this.submit(form,`${url}/${this.loginUrl}`,form.data)
    }

    submit(form, action, data) {
        return new Promise((resolve, reject) => {
            form.post(action, data)
                .then(({data}) => resolve(data))
                .catch(error => reject(error.response.data))
        })
    }

    loggedIn () {
        return !!this.storage.token
    }

    setToken(token) {
        this.storage.token = token
    }

    logout(form, url) {
        this.submit(form,`${url}/${this.logoutUrl}`,form.data)
    }
}