/**
 * Universal Tagify initializer
 *
 * @param {string} selector - input selector
 * @param {object} options - Tagify options (optional)
 */

// 'use strict';

// window.initTagify = function (selector, options = {}) {
//     const el = document.querySelector(selector);
//     if (!el) return null;

//     // Prevent double init
//     if (el._tagify) return el._tagify;

//     const defaultOptions = {
//         delimiters: ",",
//         dropdown: {
//             enabled: 0
//         }
//     };

//     const tagify = new Tagify(el, {
//         ...defaultOptions,
//         ...options
//     });

//     return tagify;
// };
'use strict';

window.initTagify = function (selector, options = {}) {
    const el = document.querySelector(selector);
    if (!el) return null;

    if (el._tagify) return el._tagify;

    const defaultOptions = {
        delimiters: ",|\n",
        dropdown: { enabled: 0 }
    };

    return new Tagify(el, {
        ...defaultOptions,
        ...options
    });
};
