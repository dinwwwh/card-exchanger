<script setup>
import dayjs from '~/dayjs';

import StatusBadgeVue from '~/Components/Card/StatusBadge';

const props = defineProps({
    cards: Array,
    fields: {
        type: Array,
        default: () => ['serial', 'status', 'updatedAt'],
    },
});
</script>

<template>
    <div class="shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th
                        v-for="field in props.fields"
                        :key="field"
                        scope="col"
                        class="
                            px-6
                            py-3
                            text-left text-xs
                            font-medium
                            text-gray-500
                            uppercase
                            tracking-wider
                        "
                    >
                        <span v-if="field === 'serial'" class="text-gray-700">
                            Số serial
                        </span>
                        <span v-else-if="field === 'createdAt'"> Đổi </span>
                        <span v-else-if="field === 'status'"> Trạng thái </span>
                        <span v-else-if="field === 'updatedAt'">
                            Cập nhật
                        </span>
                        <span v-else-if="field === 'actions'" class="sr-only">
                            Hành động
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="card in props.cards"
                    :key="card.id"
                    class="odd:bg-white even:bg-gray-50"
                >
                    <td
                        v-for="field in props.fields"
                        :key="field + card.id"
                        class="
                            px-6
                            py-4
                            whitespace-nowrap
                            text-sm
                            font-medium
                            text-gray-500
                        "
                    >
                        <span v-if="field === 'serial'" class="text-gray-700">
                            {{ card.serial }}
                        </span>
                        <span v-else-if="field === 'status'">
                            <StatusBadgeVue :card="card" />
                        </span>
                        <span v-else-if="field === 'createdAt'">
                            {{ dayjs(card.createdAt).fromNow() }}
                        </span>
                        <span v-else-if="field === 'updatedAt'">
                            {{ dayjs(card.updatedAt).fromNow() }}
                        </span>
                        <span v-else-if="field === 'actions'"> </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
