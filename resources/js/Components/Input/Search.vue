<script setup>
import BasicInput from '~/Components/Input';
import { SearchIcon } from '@heroicons/vue/outline';
import { Loading as LoadingIcon } from '~/Components/icons';

const props = defineProps({
    isSearching: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <BasicInput>
        <template #icon="iconAttrs">
            <SearchIcon v-if="!props.isSearching" v-bind="iconAttrs" />
            <LoadingIcon v-else v-bind="iconAttrs" class="animate-spin" />
        </template>

        <slot />

        <template #description>
            <slot name="description" />
        </template>
    </BasicInput>
</template>
