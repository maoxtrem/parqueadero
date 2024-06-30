import { table_operate, table_id, table_radio, footerCount, footerSuma, table_campo } from "./util";
$('#table_home').bootstrapTable({
    showFooter: true,
    resizable: true,
    showRefresh: true,
    pagination: true,
    buttonsAlign: "left",
    buttonsPrefix: "btn-sm btn",
    theadClasses: ['table-primary',].join(' '),
    classes: ['table', 'table-borderless', 'table-hover', 'table-striped', 'table-sm', 'table-radius'].join(' '),
    columns: [
        [
            {
                align: "center",
                title: "Lista de:",
                colspan: 5
            }
        ],
        [
            table_radio(),
            table_id(),
            table_campo("name", "Name"),
            table_campo("price", "Item Price"),
            table_operate(edit, delet)
        ]
    ],
    data: data_test()
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





