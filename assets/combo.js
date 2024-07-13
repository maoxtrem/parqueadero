// main.js

import { combo, comboCascade } from './util';


document.addEventListener('DOMContentLoaded', async () => {
  //  toastr.error('Please enter a number.', 'Error');
  const combos = [
    { el: '#pais', url: rutes.pais, defaultValue: 0},
    { el: '#departamento', url: rutes.departamento, defaultValue: 2 },
    { el: '#municipio', url: rutes.municipio, defaultValue: 1 },

  ];
  await comboCascade(combos);
  combo([
    {id:0,name:'seleccione un campo'},
    {id:1,name:'Hombre'},
    {id:2,name:'Mujer'},
  ],'#sexo')
});
