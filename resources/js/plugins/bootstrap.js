/**
 * O Echo expõe uma API expressiva para se inscrever em canais e ouvir
 * para eventos que são transmitidos pelo Laravel. Transmissão de eco e evento
 * permite que sua equipe crie facilmente aplicativos da Web em tempo real robustos.
 */
window._ = require('lodash');


import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '7f97e31c390ff972f1df',
    cluster: 'us2',
    encrypt: true
});
