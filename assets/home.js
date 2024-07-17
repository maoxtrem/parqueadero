
import { table_operate, table_id, table_radio, table_campo, bootstrap, on} from "./util";



$('#table_home').bootstrapTable({
    showFooter: true,
    resizable: true,
    showRefresh: true,
    pagination: true,
    sortable: true,
    sidePagination: "server",
    url: rutes.list_user,
    buttonsAlign: "left",
    buttonsPrefix: "btn-sm btn",
    theadClasses: ['table-custom'].join(' '),
    classes: ['table', 'table-borderless', 'table-hover', 'table-sm', 'table-radius'].join(' '),
    columns: [
        [
            {
                align: "center",
                title: "Lista de:",
                colspan: 4

            }
        ],
        [
            table_radio(),
            table_id(),
            table_campo('username', 'name'),
            table_operate(edit, delet)

        ]
    ]
})

const modal = new bootstrap.Modal('#staticBackdrop')

on('shown.bs.modal', modal._element, (e) => {

})

function edit(row) {
    modal.show();
}

function delet(row) {
}






