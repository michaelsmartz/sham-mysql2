'use strict';
 
const fs = require('fs');
const postcss = require('postcss');
const css = fs.readFileSync('public/css/app.css');
 
postcss([require('postcss-combine-duplicated-selectors')])
  .process(css, {from: 'public/css//app.css', to: 'public/css/postcss.css', removeDuplicatedProperties: true})
  .then((result) => {
    fs.writeFileSync('public/css/postcss.css', result.css);
    if (result.map) fs.writeFileSync('public/css/postcss.css.map', result.map);
  });