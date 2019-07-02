import {on} from "delegated-events";

window.on = global.on = on;

require('sumoselect');
require('parsleyjs');

$('.select-multiple').SumoSelect({csvDispCount: 10, up: true});

