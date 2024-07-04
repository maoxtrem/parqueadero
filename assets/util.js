import Swal from 'sweetalert2/dist/sweetalert2.js'
import * as allbootstrap from "bootstrap";
export const bootstrap = allbootstrap;
/**
 * Easy selector helper function
 */
export const select = (el, all = false) => {


    if (typeof el === 'object') {
        return el;
    }

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

/**
 * Easy on scroll event listener 
 */
export const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
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
        if (result.isDismissed) {
            return action();
        }
    });
}


/**
 * Action delete and edit bootstrao-table 
 */

export const operateEvents = (edit, delet) => {
    return {
        'click .edit': (e, value, row, index) => {
            edit(row);
        },
        'click .delete': (e, value, row, index) => {
            delet(row);
        }
    }
}

export const operateFormatter = () => {
    return [
        '<a class="edit" href="javascript:void(0)">',
        '<i class="text-primary bi bi-pencil-square"></i>',
        '</a>',
        '<a class="delete" href="javascript:void(0)">',
        '<i class="text-danger bi bi-trash"></i>',
        '</a>'
    ].join('')
}

export const table_operate = (edit, delet) => {
    return {
        field: 'operate',
        title: 'Accion',
        align: "center",
        halign: "center",
        width: "0.1",
        widthUnit: "rem",
        formatter: operateFormatter,
        events: operateEvents(edit, delet)
    }
}
export const table_id = (formatter = false) => {
    if (formatter) {
        return {
            field: "id",
            title: "ID",
            align: "center", width: "0.1", widthUnit: "rem", sortable: true, footerFormatter: footerTotal
        }
    }
    return { field: "id", title: "ID", align: "center", width: "0.1", widthUnit: "rem", sortable: true }
}
export const table_campo = (field, title, footerFormatter = () => { }) => {
    return { field, title, align: "left", halign: "left", sortable: true, footerFormatter }
}
export function table_radio() { return { field: "radio", radio: true } }
export function footerTotal() { return 'Total' };
export function footerCount(data) { return data.length };
export function footerSuma(data) {
    return data.map(row => row[this.field]).reduce((sum, i) => sum + i, 0)
}
