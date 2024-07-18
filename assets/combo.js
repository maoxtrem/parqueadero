import { bootstrap, on, fetch_async_formData, confirmar, formatt_campo, configBootstrapTableDefault } from "./util";


$('#table_paises').bootstrapTable({
  ...configBootstrapTableDefault,
  url: rutes.list_paises,
  buttons: add_pais,
  columns: [
    [{ align: "center", title: "Lista de: paises", colspan: 5 }],
    [
      formatt_campo(),
      formatt_campo({ type: 'text', name: 'nombre' }),
      ...formatt_campo({ type: 'relation', name: 'test' },false,true),
      formatt_campo({ type: 'operate', name: '', events: { edit: editPais, delet: deletPais } })
    ]
  ]
})

const modal = new bootstrap.Modal('#modalPaises')

on('shown.bs.modal', modal._element, (e) => {
  console.log('show');
})

on('hidden.bs.modal', modal._element, (e) => {
  console.log('hide');
})

function editPais(row) {
  modal.show();
}

async function deletPais(row) {
  let formData = new FormData();
  formData.append('delete', true);
  formData.append('id', row.id);
  confirmar(action);
  async function action() {
    await fetch_async_formData(rutes.crud_pais, formData)
    $('#table_paises').bootstrapTable('refresh')
  }

}

function add_pais() {
  return {
    btnAdd: {
      text: 'nuevo pais',
      icon: 'bi bi-plus-square',
      event: () => {
        modal.show();
      },
      attributes: {
        title: 'nuevo pais',
        class: 'btn-success'
      }
    }
  }
}



document.addEventListener('DOMContentLoaded', async () => {




});
