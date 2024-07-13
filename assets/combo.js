// main.js


import toastr from 'toastr';
import { combo, comboDependienteFetch, comboFetch, select } from './util';


document.addEventListener('DOMContentLoaded', async () => {
  //  toastr.error('Please enter a number.', 'Error');
  await comboDependienteFetch(rutes.pais, '#example',1,rutes.depto,'#exampleDependiente',1);
});




const getList = () => {
  return [{
    id: '1',
    name: 'colombia'
  },
  {
    id: '2',
    name: 'venezuela'
  }, {
    id: '3',
    name: 'peru'
  }]
}