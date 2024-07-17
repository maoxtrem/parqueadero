// main.js


// assets/js/app.js


import { $$, comboCascade } from './util';
document.addEventListener('DOMContentLoaded', async () => {


  const birdData = [
    { "label": "Eagle", "id": 1 },
    { "label": "Sparrow", "id": 2 },
    { "label": "Pigeon", "id": 3 },
    { "label": "Parrot", "id": 4 },
    { "label": "Owl", "id": 5 }
  ];


  $$("#birds").autocomplete({
    minLength: 2,
    source: birdData,
    select: function (event, ui) {
      console.log(ui.item.value);
    }
  });

  await comboCascade([
    { url: rutes.pais, el: "#pais", defaultValue: 0 },
    { url: rutes.departamento, el: "#departamento", defaultValue: 0 },
    { url: rutes.municipio, el: "#municipio", defaultValue: 0 },
  ])

});
