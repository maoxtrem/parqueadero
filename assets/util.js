import Swal from 'sweetalert2/dist/sweetalert2.js'
import * as allbootstrap from "bootstrap";
export const bootstrap = allbootstrap;
import jquery from 'jquery';
export const $$ = jquery;
const cache = new Map();
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


export const fetch_async_formData = async (url, formData = new FormData(), isCache = false) => {
    const cacheKey = `${url}-${formData ? JSON.stringify([...formData]) : ''}`;
    if (isCache) {
        if (cache.has(cacheKey)) {
            return cache.get(cacheKey);
        }
    }
    try {
        const response = await fetch(url, { method: 'POST', body: formData });
        if (!response.ok) { throw new Error('Error en el servidor code:500'); }
        const data = await response.json();
        isCache && cache.set(cacheKey, data);
        return data;
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

export const confirmar = (action = () => { }) => {
    Swal.fire({
        title: "Quieres hacer esto?",
        text: "Esta accion es irevercible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si"
    }).then((result) => {
        if (result.isConfirmed) {
            return action();
        }
    });
}

/**
 * Action delete and edit bootstrao-table 
 */

export const operateEvents = (edit = () => { }, delet = () => { }) => {
    return {
        'click .edit': async (e, value, row, index) => {
            await edit(row);
        },
        'click .delete': async (e, value, row, index) => {
            await delet(row);
        }
    }
}

export const statusEvents = (actionStatus = () => { }) => {
    return {
        'click .status': async (e, value, row, index) => {
            actionStatus(value, row, index);
        }
    }
}
/**
 * Action botones bootstrao-table 
 */

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

export const statusFormatter = (value, row, index) => {
    return [
        '<a class="status" href="javascript:void(0)">',
        `<i class="bi bi-circle-fill text-${value ? 'success' : 'danger'}"></i>`,
        '</a>'
    ].join('')
}

/**
 * footer de bootstrao-table 
 */
export function footerTotal() { return 'Total' };
export function footerCount(data) { return data.length };
export function footerSuma(data) { return data.map(row => row[this.field]).reduce((sum, i) => sum + i, 0) }
export function footerPromedio(data) { return data.map(row => (+row[this.field]).reduce((sum, i) => sum + i, 0) / data.length).toFixed(1); }
/**
 * formato de los campos de bootstrao-table 
 */
export const formatt_campo = (data = { type: 'id', name: 'id', events: { edit: () => { }, delet: () => { }, actionStatus: () => { } } }, total = false, debug = false) => {
    let campos = {}
    const { type, name } = data;
    const width = { width: "0.1", widthUnit: "rem" };
    const aling_valing = { align: 'center', valign: 'middle' };
    const atrib_basic = { title: name.replace(/_/g, ' ').toUpperCase(), sortable: true, ...aling_valing };
    switch (type) {
        case 'id':
            return {
                field: name,
                ...atrib_basic,
                ...width,
                ...total ? { footerFormatter: footerTotal } : {}
            }
        case 'text':
            campos = {
                title: atrib_basic.title,
                field: 'name_' + name,
                align: "left",
                halign: "left",
                sortable: atrib_basic.sortable
            }
            debug && (campos.title = 'name_' + name);
            return campos
        case 'operate':
            const { edit, delet } = data.events;
            return {
                title: 'ACCION',
                field: 'operate',
                align: "center",
                halign: "center",
                ...width,
                clickToSelect: false,
                formatter: operateFormatter,
                events: operateEvents(edit, delet)
            }
        case 'status':
            const { actionStatus } = data.events;
            return {
                title: 'STATUS',
                field: 'status',
                align: "center",
                halign: "center",
                ...width,
                clickToSelect: false,
                formatter: statusFormatter,
                events: statusEvents(actionStatus)
            }
        case 'radio':
            return { field: "radio", radio: true }
        case 'state':
            return { field: 'state', checkbox: true, ...aling_valing }
        case 'relation':
            let campo1 = {
                title: atrib_basic.title, field: 'name_' + name,
                align: "left",
                halign: "left",
                sortable: atrib_basic.sortable
            }
            debug && (campo1.title = 'name_' + name);
            let campo2 = { field: 'id_' + name, visible: debug }
            debug && (campo2.title = 'id_' + name);
            return [campo1, campo2];
        case 'totalTextFormatter':
        case 'totalCountFormatter':
        case 'totalSumaFormatter':
        case 'totalPromedioFormatter':
            let formatter = { footerFormatter: footerTotal };
            (data.type === 'totalCountFormatter') && (formatter.footerFormatter = footerCount);
            (data.type === 'totalSumaFormatter') && (formatter.footerFormatter = footerSuma);
            (data.type === 'totalPromedioFormatter') && (formatter.footerFormatter = footerPromedio);
            campos = {
                field: 'name_' + name,
                title: atrib_basic.title,
                sortable: atrib_basic.sortable,
                ...aling_valing,
                ...formatter
            }
            debug && (campos.title = 'name_' + name);
            return campos;
    }
}

/**
 * preconficuracion de la tabla de bootstrao-table 
 */

export const configBootstrapTableDefault = {
    showFooter: true,
    resizable: true,
    showRefresh: true,
    pagination: true,
    sortable: true,
    buttonsAlign: "left",
    buttonsPrefix: "btn-sm btn",
    theadClasses: ['table-custom'].join(' '),
    classes: ['table', 'table-borderless', 'table-hover', 'table-sm', 'table-radius'].join(' ')
}


/**
 * combo dependiente
 */

export const  combo = async (options, el, defaultValue = 0) => {
    const selectElement = select(el);
    if (!selectElement) {
        console.error(`Element with id ${el} not found.`);
        return;
    }
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
    const options = await fetch_async_formData(url, formData, true);
    await combo(options, el, defaultValue);
}


export const comboCascade = async (combos) => {
    //ej: {url:'', el:'#', defaultValue:0}
    // Initialize the first combo box
    const firstCombo = combos[0];
    await comboFetch(firstCombo.url, firstCombo.el, firstCombo.defaultValue);

    // Function to create change event listeners for the combo boxes
    const createChangeListener = (currentCombo, nextCombo) => {
        on('change', currentCombo.el, async (e) => {
            const formData = new FormData();
            formData.append('id', e.target.value);
            await comboFetch(nextCombo.url, nextCombo.el, nextCombo.defaultValue, formData);
            // Trigger change event on the next combo box if it has further dependencies
            const nextComboIndex = combos.indexOf(nextCombo);
            if (nextComboIndex < combos.length - 1) {
                select(nextCombo.el).dispatchEvent(new Event('change'));
            }
        });
    };

    // Set up change event listeners for cascading combo boxes
    for (let i = 0; i < combos.length - 1; i++) {
        createChangeListener(combos[i], combos[i + 1]);
    }

    // Trigger change event on the first combo box to start the cascade
    select(firstCombo.el).dispatchEvent(new Event('change'));
};

export const multiCombos = async (combos) => {
    combos.forEach(async combo => {
        await comboFetch(combo.url, combo.el, combo.defaultValue);
        if (typeof combo.listener === 'function') {
            on('change', combo.el, (e) => {
                combo.listener(e);
            });
        }
    })

};

export const selectIsValid = (el) => {

    const selectElement = select(el);
    selectElement.setCustomValidity('');
    if (selectElement.value == 0) {
        selectElement.setCustomValidity('Completa este campo');
        return true
    } else {
        selectElement.setCustomValidity('');
        return false
    }
}