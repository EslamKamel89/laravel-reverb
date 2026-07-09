import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
function pr(val, title = "") {
    console.log("---------------------------------");
    if (title) console.log(title);
    console.log(val);
    return val;
}
window.pr = pr;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import "./echo";
