
import { configBootstrapTableDefault, formatt_campo,bootstrap, on} from "./util";


const encabezado_paises = [
    formatt_campo({ type: 'radio',name: '' }),
    formatt_campo(),
    formatt_campo({ type: 'text', name: 'username' }),
    formatt_campo({ type: 'operate', name: '', events: { edit: edit, delet: delet } })
  ];
  const title_paises = [{ align: "center", title: "Lista de: usuarios", colspan: encabezado_paises.length }];
  
  $('#table_paises').bootstrapTable({
    ...configBootstrapTableDefault,
    columns: [title_paises, encabezado_paises],
    url: rutes.list_user,
    sidePagination: "server"
  })


const modal = new bootstrap.Modal('#staticBackdrop')

on('shown.bs.modal', modal._element, (e) => {

})

function edit(row) {
    modal.show();
}

function delet(row) {
}






