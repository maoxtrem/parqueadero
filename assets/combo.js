import { bootstrap, on, fetch_async_formData, confirmar, formatt_campo, configBootstrapTableDefault, select, combo, comboFetch, multiCombos, comboCascade } from "./util";

/**
 * crud combo paises
 */
const encabezado_paises = [
  formatt_campo(),
  formatt_campo({ type: 'text', name: 'pais' }),
  formatt_campo({ type: 'operate', name: '', events: { edit: editPais, delet: deletPais } })
];
const title_paises = [{ align: "center", title: "Lista de: paises", colspan: encabezado_paises.length }];

$('#table_paises').bootstrapTable({
  ...configBootstrapTableDefault,
  columns: [title_paises, encabezado_paises],
  url: rutes.list_paises,
  buttons: btns_pais
})

const modalPaises = new bootstrap.Modal('#modalPaises')

on('hidden.bs.modal', modalPaises._element, (e) => {
  select('#id_pais').value = 0;
  select('#pais').value = '';
})

on('submit', '#form_paises', async (e) => {
  e.preventDefault();
  let formData = new FormData(e.target);
  formData.append('delete', 0);
  await fetch_async_formData(rutes.crud_pais, formData)
  $('#table_paises').bootstrapTable('refresh')
  $('#table_departamento').bootstrapTable('refresh')
  modalPaises.hide();
})
function editPais(row) {
  select('#id_pais').value = row.id;
  select('#pais').value = row.name_pais;
  modalPaises.show();
}

async function deletPais(row) {
  let formData = new FormData();
  formData.append('delete', 1);
  formData.append('id', row.id);
  confirmar(action);
  async function action() {
    await fetch_async_formData(rutes.crud_pais, formData);
    $('#table_paises').bootstrapTable('refresh');
    $('#table_departamento').bootstrapTable('refresh')
  }
}

function btns_pais() {
  return {
    btnAdd: {
      text: 'nuevo pais',
      icon: 'bi bi-plus-square',
      event: () => {
        modalPaises.show();
      },
      attributes: {
        title: 'nuevo pais',
        class: 'btn-success'
      }
    }
  };
}

/**
 * crud combo departamentos
 */

const encabezadoDepartamento = [
  formatt_campo(),
  formatt_campo({ type: 'text', name: 'departamento' }),
  ...formatt_campo({ type: 'relation', name: 'pais' }),
  formatt_campo({ type: 'operate', name: '', events: { edit: editDepartamento, delet: deletDepartamento } })
];
const titleDepartamento = [{ align: "center", title: "Lista de: Departamento", colspan: encabezadoDepartamento.length }];

$('#table_departamento').bootstrapTable({
  ...configBootstrapTableDefault,
  columns: [titleDepartamento, encabezadoDepartamento],
  url: rutes.list_deprtamento,
  buttons: btns_departamento
})

const modalDepartamento = new bootstrap.Modal('#modalDepartamento')

on('hidden.bs.modal', modalDepartamento._element, (e) => {
  select('#id_departamento').value = 0;
  select('#departamento').value = '';
})

on('shown.bs.modal', modalDepartamento._element, async (e) => {
  
  //select('#id_departamento').value = 0;
  //select('#departamento').value = '';
})

on('submit', '#form_departamento', async (e) => {
  e.preventDefault();
  let formData = new FormData(e.target);
  formData.append('delete', 0);
  console.log(rutes.crud_departamento);
  await fetch_async_formData(rutes.crud_departamento, formData)
  $('#table_departamento').bootstrapTable('refresh')
  modalDepartamento.hide();
})

async function editDepartamento(row) {
  select('#id_departamento').value = row.id;
  select('#departamento').value = row.name_departamento;
  await comboFetch(rutes.list_combo_paises, '#select_pais', row.id_pais)
  modalDepartamento.show();
}

async function deletDepartamento(row) {
  let formData = new FormData();
  formData.append('delete', 1);
  formData.append('id', row.id);
  confirmar(action);
  async function action() {
    await fetch_async_formData(rutes.crud_departamento, formData);
    $('#table_departamento').bootstrapTable('refresh');
  }
}

function btns_departamento() {
  return {
    btnAdd: {
      text: 'nuevo Departamento',
      icon: 'bi bi-plus-square',
      event: async () => {
        await comboFetch(rutes.list_combo_paises, '#select_pais', 0)
        modalDepartamento.show();
      },
      attributes: {
        title: 'nuevo Departamento',
        class: 'btn-success'
      }
    }
  };
}

on('DOMContentLoaded', document, (e) => {

})