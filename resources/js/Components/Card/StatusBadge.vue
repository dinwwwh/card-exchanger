<script setup>
import { computed } from 'vue';
import Badge from '~/Components/Badge';

const props = defineProps({
    card: Object,
});

const meaning = computed(() => {
    if (props.card.approverId === null && props.card.approvedAt === null)
        return {
            text: 'Chờ được phê duyệt',
            class: '!bg-yellow-100 !text-yellow-800',
        };

    if (props.card.approverId !== null && props.card.approvedAt === null)
        return {
            text: 'Đang phê duyệt',
            class: '!bg-blue-100 !text-blue-800',
        };

    if (
        props.card.approverId !== null &&
        props.card.approvedAt !== null &&
        props.card.receivedValue === 0
    )
        return {
            text: 'Thẻ sai thông tin',
            class: '!bg-red-100 !text-red-800',
        };

    if (
        props.card.approverId !== null &&
        props.card.approvedAt !== null &&
        props.card.receivedValue !== 0 &&
        props.card.paidAt === null
    )
        return {
            text: 'Chờ thanh toán',
            class: '!bg-yellow-100 !text-yellow-800',
        };

    if (
        props.card.approverId !== null &&
        props.card.approvedAt !== null &&
        props.card.receivedValue !== 0 &&
        props.card.paidAt !== null
    )
        return {
            text: 'Đã thanh toán',
            class: '!bg-green-100 !text-green-800',
        };

    return {
        text: 'Lỗi, báo admin ngay',
        class: '!bg-red-100 !text-red-800',
    };
});
</script>

<template>
    <Badge :class="meaning.class"> {{ meaning.text }} </Badge>
</template>
