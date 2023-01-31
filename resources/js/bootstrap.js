import _ from 'lodash';
import Alpine from 'alpinejs';
import axios from 'axios';
import EasyMDE from 'easymde';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * EasyMDE
 * https://github.com/Ionaru/easy-markdown-editor
 *
 * Digunakan pada blade components
 */
window.EasyMDE = EasyMDE;


/**
 * Alpine.js
 * https://alpinejs.dev/
 */
window.Alpine = Alpine;

Alpine.start();
