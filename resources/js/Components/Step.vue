<script setup>
const emits = defineEmits(['update:currentStep']);

const props = defineProps({
    currentStep: {
        type: Number,
        required: true,
    },
    steps: {
        type: Array,
        required: true,
    },
});

function move(step) {
    emits('update:currentStep', step);
}
</script>

<template>
    <ol role="list" class="space-y-4 md:flex md:space-y-0 md:space-x-8">
        <li
            v-for="(step, i) in steps"
            :key="i"
            class="md:flex-1 cursor-pointer"
            @click="move(step)"
        >
            <div
                v-if="i < currentStep - 1"
                class="
                    group
                    pl-4
                    py-2
                    flex flex-col
                    border-l-4 border-indigo-600
                    hover:border-indigo-800
                    md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4
                "
            >
                <span
                    class="
                        text-xs text-indigo-600
                        font-semibold
                        tracking-wide
                        uppercase
                        group-hover:text-indigo-800
                    "
                >
                    Bước {{ i + 1 }}
                </span>
                <span class="text-sm font-medium">{{ step }}</span>
            </div>
            <div
                v-else-if="i === currentStep - 1"
                class="
                    pl-4
                    py-2
                    flex flex-col
                    border-l-4 border-indigo-600
                    md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4
                "
                aria-current="step"
            >
                <span
                    class="
                        text-xs text-indigo-600
                        font-semibold
                        tracking-wide
                        uppercase
                    "
                >
                    Bước {{ i + 1 }}
                </span>
                <span class="text-sm font-medium">{{ step }}</span>
            </div>
            <div
                v-else
                class="
                    group
                    pl-4
                    py-2
                    flex flex-col
                    border-l-4 border-gray-200
                    hover:border-gray-300
                    md:pl-0 md:pt-4 md:pb-0 md:border-l-0 md:border-t-4
                "
            >
                <span
                    class="
                        text-xs text-gray-500
                        font-semibold
                        tracking-wide
                        uppercase
                        group-hover:text-gray-700
                    "
                >
                    Bước {{ i + 1 }}
                </span>
                <span class="text-sm font-medium">{{ step }}</span>
            </div>
        </li>
    </ol>
</template>
