import Postcodenl from "./fieldtypes/Postcodenl.vue";

Statamic.booting(() => {
    Statamic.component('postcodenl-fieldtype', Postcodenl);
});