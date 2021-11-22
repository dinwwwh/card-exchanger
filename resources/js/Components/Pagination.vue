<script setup>
import { reactive, computed } from 'vue';
import { paginate } from '~/utils';
import {
    ArrowNarrowRightIcon,
    ArrowNarrowLeftIcon,
} from '@heroicons/vue/outline';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    meta: Object,
    quantityPerEnd: {
        type: Number,
        default: 2,
    },
    href: String,
    method: {
        type: String,
        default: 'get',
    },
    data: {
        type: Object,
        default: () => ({}),
    },
});

function getBindingData(page) {
    return {
        href: props.href,
        method: props.method,
        data: {
            ...props.data,
            page,
        },
    };
}

const pagination = computed(() => {
    return paginate(
        props.meta.currentPage,
        props.meta.lastPage,
        props.quantityPerEnd
    );
});
function isCurrentPage(page) {
    return props.meta.currentPage === page;
}

const emits = defineEmits(['change']);
function change(page) {
    emits('change', page);
}
</script>

<template>
    <nav
        class="
            border-t border-gray-200
            px-4
            flex
            items-center
            justify-between
            sm:px-0
        "
    >
        <!-- Previous page -->
        <div class="-mt-px w-0 flex-1 flex">
            <Link
                v-if="pagination.previousPage"
                class="
                    border-t-2 border-transparent
                    pt-4
                    pr-1
                    inline-flex
                    items-center
                    text-sm
                    font-medium
                    text-gray-500
                    hover:text-gray-700 hover:border-gray-300
                    cursor-pointer
                "
                v-bind="getBindingData(pagination.previousPage)"
                @click="change(pagination.previousPage)"
            >
                <ArrowNarrowLeftIcon class="mr-3 h-6 text-gray-400" />
                Trước
            </Link>
        </div>

        <div class="hidden md:-mt-px md:flex">
            <!-- First page -->
            <Link
                class="
                    border-t-2
                    pt-4
                    px-4
                    inline-flex
                    items-center
                    text-sm
                    font-medium
                "
                :class="{
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 cursor-pointer':
                        !isCurrentPage(1),
                    'border-indigo-500 text-indigo-600': isCurrentPage(1),
                }"
                v-bind="getBindingData(1)"
                @click="change(1)"
            >
                1
            </Link>

            <!-- ... -->
            <span
                v-if="pagination.pages[0] > 2"
                class="
                    border-transparent
                    text-gray-500
                    border-t-2
                    pt-4
                    px-4
                    inline-flex
                    items-center
                    text-sm
                    font-medium
                "
            >
                ...
            </span>

            <!-- Pages -->
            <Link
                v-for="(page, i) in pagination.pages"
                :key="i"
                class="
                    border-t-2
                    pt-4
                    px-4
                    inline-flex
                    items-center
                    text-sm
                    font-medium
                "
                :class="{
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 cursor-pointer':
                        !isCurrentPage(page),
                    'border-indigo-500 text-indigo-600': isCurrentPage(page),
                }"
                v-bind="getBindingData(page)"
                @click="change(page)"
            >
                {{ page }}
            </Link>

            <!-- ... -->
            <span
                v-if="pagination.pages.slice(-1)[0] < props.meta.lastPage - 1"
                class="
                    border-transparent
                    text-gray-500
                    border-t-2
                    pt-4
                    px-4
                    inline-flex
                    items-center
                    text-sm
                    font-medium
                "
            >
                ...
            </span>

            <!-- Last page -->
            <Link
                v-if="props.meta.lastPage > 1"
                class="
                    border-t-2
                    pt-4
                    px-4
                    inline-flex
                    items-center
                    text-sm
                    font-medium
                "
                :class="{
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 cursor-pointer':
                        !isCurrentPage(props.meta.lastPage),
                    'border-indigo-500 text-indigo-600': isCurrentPage(
                        props.meta.lastPage
                    ),
                }"
                v-bind="getBindingData(props.meta.lastPage)"
                @click="change(props.meta.lastPage)"
            >
                {{ props.meta.lastPage }}
            </Link>
        </div>

        <!-- Next page -->
        <div class="-mt-px w-0 flex-1 flex justify-end">
            <Link
                v-if="pagination.nextPage"
                class="
                    border-t-2 border-transparent
                    pt-4
                    pl-1
                    inline-flex
                    items-center
                    text-sm
                    font-medium
                    text-gray-500
                    hover:text-gray-700 hover:border-gray-300
                    cursor-pointer
                "
                v-bind="getBindingData(pagination.nextPage)"
                @click="change(pagination.nextPage)"
            >
                Sau
                <ArrowNarrowRightIcon class="ml-3 h-6 text-gray-400" />
            </Link>
        </div>
    </nav>
</template>
