import { table_operate, table_id, table_radio, footerCount, footerSuma, table_campo } from "./util";


console.log(rutes);

$('#table_home').bootstrapTable({
    showFooter: true,
    resizable: true,
    showRefresh: true,
    pagination: true,
    sortable:true,
    sidePagination: "server",
    url: rutes.list_user,
    buttonsAlign: "left",
    buttonsPrefix: "btn-sm btn",
    theadClasses: ['table-primary',].join(' '),
    classes: ['table', 'table-borderless', 'table-hover', 'table-striped', 'table-sm', 'table-radius'].join(' '),
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


function edit(row) {
    console.debug(row)
}

function delet(row) {
    console.debug(row)
}


function data_test() {
    return Array.from({ length: 30 }, (_, index) => ({
        radio: false,
        id: ++index,
        name: `Item ${++index}`,
        price: ++index
    }));
};





