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
 */
// window.EasyMDE = EasyMDE;
new EasyMDE({
    element: document.getElementById('easymde-markdown-editor'),
    minHeight: '150px',
    forceSync: true,
    toolbar: [
        'bold', 'italic', 'heading',
        '|', 'code','quote', 'unordered-list', 'ordered-list',
        '|', 'link', 'image',
        '|', 'preview', 'side-by-side', 'fullscreen',
        '|', 'guide'
    ]
});

/**
 * Alpine.js
 * https://alpinejs.dev/
 */
window.Alpine = Alpine;

Alpine.start();
