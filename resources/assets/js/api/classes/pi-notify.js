export default class Notify {

    set(element, message, type = 'success', primary = true, time = 3000) {
        primary = primary ? 'alert-primary' : 'alert-secondary'
        type = `alert-${type}`
        let content = `<div id="pi-notify" class="alert ${primary} ${type}" role="alert" v-if="display">${message}</div>`
        Notify.appendAlert(element, content)
        this.clear(document.getElementById('pi-notify'), time)
    }

    clear(element, time) {
        setTimeout(() => {
            element.parentNode.removeChild(element)
        }, time)
    }

    static appendAlert(element, content) {
        element.body.innerHTML = element.body.innerHTML + content
    }
}