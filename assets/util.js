import Swal from 'sweetalert2/dist/sweetalert2.js'

/**
 * Easy selector helper function
 */
export const select = (el, all = false) => {
    el = el.trim()
    if (all) {
        return [...document.querySelectorAll(el)]
    } else {
        return document.querySelector(el)
    }
}

/**
 * Easy event listener function
 */
export const on = (type, el, listener, all = false) => {
    if (all) {
        select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
        select(el, all).addEventListener(type, listener)
    }
}

export const fetch_async_formData = async (url, formData = new FormData()) => {
    try {
        const response = await fetch(url, { method: 'POST', body: formData });
        if (!response.ok) { throw new Error('Error en el servidor code:500'); }
        return await response.json();
    } catch (error) {
        return { message: { icon: "error", title: "Oops...", text: error.message } };
    }
}

export const message_server = (message, action = () => { }) => {
    Swal.fire(message).then((result) => {
        if(result.isDismissed){
            return action();
        }
    });
}