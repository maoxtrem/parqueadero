import { bootstrap, on, fetch_async_formData, confirmar, formatt_campo, configBootstrapTableDefault, select, combo, comboFetch, multiCombos, comboCascade } from "./util";

const encabezado = [
  formatt_campo(),
  formatt_campo({ type: 'text', name: 'nombre' }),
  formatt_campo({ type: 'operate', name: '', events: { edit: editPais, delet: deletPais } })
];

$('#table_paises').bootstrapTable({
  ...configBootstrapTableDefault,
  url: rutes.list_paises,
  buttons: add_pais,
  columns: [
    [{ align: "center", title: "Lista de: paises", colspan: encabezado.length }],
    encabezado
  ]
})

const modal = new bootstrap.Modal('#modalPaises')

on('shown.bs.modal', modal._element, (e) => {
  console.log('show');
})

on('hidden.bs.modal', modal._element, (e) => {
  select('#id_pais').value = 0;
  select('#pais').value = '';
})

on('submit', '#form_paises', async (e) => {
  e.preventDefault();
  let formData = new FormData(e.target);
  formData.append('delete', 0);
  await fetch_async_formData(rutes.crud_pais, formData)
  $('#table_paises').bootstrapTable('refresh')
  modal.hide();
})
function editPais(row) {
  select('#id_pais').value = row.id;
  select('#pais').value = row.name_nombre;
  modal.show();
}

async function deletPais(row) {
  let formData = new FormData();
  formData.append('delete', 1);
  formData.append('id', row.id);
  confirmar(action);
  async function action() {
    await fetch_async_formData(rutes.crud_pais, formData);
    $('#table_paises').bootstrapTable('refresh');
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
    },
    btnAdds: {
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
