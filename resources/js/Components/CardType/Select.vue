<script setup>
import format from 'format-number';
import Group from '~/Components/Group';

const emits = defineEmits(['update:modelValue']);
const props = defineProps({
    cardTypes: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: null,
        required: true,
    },
    expect: {
        type: Function,
        default: (type) => type,
    },
});

function select(type) {
    emits('update:modelValue', props.expect(type));
}

function isSelected(type) {
    return props.modelValue === props.expect(type);
}
</script>

<template>
    <Group class="grid xl:grid-cols-2 2xl:grid-cols-3 gap-3">
        <Group
            v-for="type in props.cardTypes"
            :key="type.id"
            class="space-y-1 cursor-pointer"
            :class="{
                'ring-2 ring-cyan-500': isSelected(type),
            }"
            @click="select(type)"
        >
            <h4 class="text-gray-700 text-lg">
                {{ type.telco }} Mệnh giá: {{ format()(type.value) }}đ
            </h4>
            <p class="text-gray-500 text-sm tracking-wider">
                Nhận được:
                {{ format()(((100 - type.fees) * type.value) / 100) }}đ
            </p>
        </Group>
    </Group>
</template>
