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
    return all ? [...document.querySelectorAll(el)] : document.querySelector(el);
}

/**
 * Easy event listener function
 */
export const on = (type, el, listener, all = false) => {
    all ? select(el, all).forEach(e => e.addEventListener(type, listener)) : select(el, all).addEventListener(type, listener);
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

export const combo = (options, el, defaultValue = 0) => {
    const selectElement = select(el);
    if (!selectElement) {
        console.error(`Element with id ${el} not found.`);
        return;
    }
    /*
        // Genera las opciones como una cadena de HTML
         const optionsHTML = options.map(option=> {
            const selected = option.id === defaultValue ? ' selected' : '';
            return `<option value="${option.id}"${selected}>${option.name}</option>`;
        }).join('');
     
        // Asigna la cadena de HTML al <select>
       selectElement.innerHTML = optionsHTML; */


    selectElement.innerHTML = ''
    options.forEach(opt => {
        let option = document.createElement("option");
        option.value = opt.id;
        option.text = opt.name;
        option.selected = opt.id == defaultValue;
        selectElement.add(option);
    });
}

export const comboFetch = async (url, el, defaultValue = 0, formData = new FormData()) => {
    const options = await fetch_async_formData(url, formData);
    combo(options, el, defaultValue);
}

export const comboDependienteFetch = async (url, el, defaultValue = 0, urlDependiente, elDependiente, defaultValueDependiente = 0) => {
    el = select(el);
    await comboFetch(url, el, defaultValue);
    on('change', el, async (e) => {
        const formData = new FormData();
        formData.append('id', e.target.value);
        await comboFetch(urlDependiente, elDependiente, defaultValueDependiente, formData);
        defaultValueDependiente = 0;
    })
    defaultValue > 0 && el.dispatchEvent(new Event('change'));
}