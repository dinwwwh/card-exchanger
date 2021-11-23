<script setup>
import { reactive, watch } from 'vue';
import { debounce } from 'lodash';
import { Inertia } from '@inertiajs/inertia';

import CardTable from '~/Components/Card/Table';
import Group from '~/Components/Group';
import Pagination from '~/Components/Pagination';
import SearchInput from '~/Components/Input/Search';

const props = defineProps({
    cards: Object,
    oldQueries: Object,
});

const search = reactive({
    value: props.oldQueries.search,
    isSearching: false,
});

watch(
    () => search.value,
    debounce(async (value) => {
        const data = value ? { search: value } : {};
        search.isSearching = true;
        Inertia.get('/cards/history/', data, {
            preserveScroll: true,
            replace: true,
            preserveState: true,
        });
        search.isSearching = false;
    }, 500)
);
</script>

<template>
    <div class="grid md:grid-cols-3 gap-3">
        <Group class="md:col-span-2 space-y-1">
            <div class="flex items-center justify-end">
                <SearchInput
                    v-model="search.value"
                    :is-searching="search.isSearching"
                    placeholder="Tìm kiếm theo số serial"
                    class="md:min-w-[300px]"
                />
            </div>

            <CardTable :cards="props.cards.data" />

            <Pagination :meta="props.cards" href="/cards/history" />
        </Group>

        <div class="space-y-3">
            <Group></Group>
            <Group></Group>
        </div>
    </div>
</template>
