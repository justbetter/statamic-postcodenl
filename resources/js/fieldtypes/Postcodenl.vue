<template>
    <div>
        <text-input :value="value" @input="update" />
    </div>
</template>

<script setup>
import { Fieldtype } from '@statamic/cms';

const emit = defineEmits(Fieldtype.emits);
const props = defineProps(Fieldtype.props);
const { expose, update } = Fieldtype.use(emit, props);
defineExpose(expose);


</script>
