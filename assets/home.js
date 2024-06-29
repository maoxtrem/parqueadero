
$('#table_home').bootstrapTable({
    showFooter: true,
    resizable: true,
    theadClasses: ['table-dark',].join(' '),
    classes: ['table', 'table-borderless', 'table-hover', 'table-striped', 'table-sm'].join(' '),
    columns: [
        [
            {
                align: "center",
                title: "Lista de:",
                colspan: 5

            }
        ],
        [
            {
                radio: true
            },
            {
                field: "id",
                title: "ID",
                align: "center",
                width: "0.1",
                widthUnit: "rem",
                footerFormatter: idFormatter
            }, {
                field: 'name',
                title: 'Item Name',
                align: "left",
                halign: "left",
                footerFormatter: nameFormatter
            }, {
                field: 'price',
                title: 'Item Price',
                align: "left",
                halign: "left",
                footerFormatter: priceFormatter
            }, {
                field: 'operate',
                title: 'Accion',
                align: "center",
                halign: "center",
                width: "0.1",
                widthUnit: "rem",
                formatter: operateFormatter,
                events: operateEvents()
            }]],
    data: data_test()
})

function operateEvents() {
    return {
        'click .edit': (e, value, row, index) => {
            console.debug(e, value, row, index)
        },
        'click .delete': (e, value, row, index) => {

        }
    }
}

function data_test() {
    const data = Array.from({ length: 100 }, (_, index) => ({
        id: ++index,
        name: `Item ${++index}`,
        price: `$${++index}`
    }));
    return data;
};




function idFormatter() { return 'Total' };

function nameFormatter(data) { return data.length };

function priceFormatter(data) {
    return '$' + data.map(row => +row[this.field].substring(1)).reduce((sum, i) => sum + i, 0)
}
function operateFormatter() {
    return [
        '<a class="edit" href="javascript:void(0)">',
        '<i class="text-primary bi bi-pencil-square"></i>',
        '</a>',
        '<a class="delete" href="javascript:void(0)">',
        '<i class="text-danger bi bi-trash"></i>',
        '</a>'
    ].join('')
}


