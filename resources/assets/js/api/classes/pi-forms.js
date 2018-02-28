import Errors from './pi-errors.js';

export default class Form {

    constructor(data) {

        this.originalData = data;

        for (let field in data) {

            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    data() {
        let data = Object.assign({}, this);
        delete data.originalData;
        delete data.errors;
        return data;
    }

    post(url) {
        return this.submit('post', url);
    }

    put(url) {
        return this.submit('put', url);
    }

    get(url) {
        return this.submit('get', url);
    }

    patch(url) {
        return this.submit('patch', url);
    }

    destroy(url) {
        return this.submit('delete', url);
    }

    reset() {
        this.originalData = [];
        this.errors.clear();
    }

    submit(reqType, url) {
        return new Promise((resolve, reject) => {
            axios[reqType](url, this.data())
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.response.data);
                    reject(error.response.data);
                })
        });
    }

    onFail(data) {
        this.errors.record(data.errors)
    }
}