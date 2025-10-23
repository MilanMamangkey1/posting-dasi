import axios from 'axios';

const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}
