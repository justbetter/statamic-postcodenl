import Postcodenl from "./fieldtypes/Postcodenl.vue";

Statamic.booting(() => {
    Statamic.$components.register('postcodenl-fieldtype', Postcodenl);
});