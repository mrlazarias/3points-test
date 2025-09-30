import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configurar Echo para broadcasting
window.Pusher = Pusher;

const echoConfig = {
    broadcaster: 'reverb',
    key: 'local',
    wsHost: window.location.hostname,
    wsPort: 8080,
    wssPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws'],
    disableStats: true,
};

try {
    window.Echo = new Echo(echoConfig);
} catch (error) {
    console.error('Erro ao inicializar Echo:', error);
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: 'local',
        wsHost: window.location.hostname,
        wsPort: 8080,
        forceTLS: false,
        enabledTransports: ['ws'],
        disableStats: true,
    });
}
