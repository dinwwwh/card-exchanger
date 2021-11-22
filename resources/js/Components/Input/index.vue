<script>
import { v1 as uuid } from 'uuid';
import { hasError, getMessage } from '~/vuelidate';

export default {
    inheritAttrs: false,
    emits: ['update:modelValue'],
    props: {
        error: {
            type: [Object, Boolean],
            default: false,
        },
    },
    data() {
        return {
            uid: uuid(),
        };
    },
    computed: {
        hasError() {
            return hasError(this.error);
        },
        errorMessage() {
            return getMessage(this.error);
        },
        isShowDescription() {
            return (
                this.errorMessage ||
                (this.$slots?.description && this.$slots?.description()?.length)
            );
        },
        hasIcon() {
            return this.$slots.icon && this.$slots.icon().length;
        },
    },
};
</script>

<template>
    <div class="space-y-1">
        <label :for="uid" class="block text-sm font-medium text-gray-700">
            <slot />
        </label>

        <div class="mt-1 relative rounded-md shadow-sm">
            <!-- Icon -->
            <div
                v-if="hasIcon"
                class="
                    absolute
                    inset-y-0
                    left-0
                    pl-3
                    flex
                    items-center
                    pointer-events-none
                "
            >
                <slot name="icon" class="h-5 w-auto text-gray-500" />
            </div>

            <!-- Input -->
            <input
                :id="uid"
                type="text"
                class="
                    focus:ring-cyan-500 focus:border-cyan-500
                    block
                    w-full
                    sm:text-sm
                    border-gray-300
                    rounded-md
                "
                :class="{
                    'pl-10': hasIcon,
                }"
                v-bind="$attrs"
                :value="$attrs.modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                @focus="error?.$reset && error.$reset()"
                @blur="error?.$touch && error.$touch()"
            />
        </div>

        <!-- Description -->
        <p
            v-if="isShowDescription"
            class="text-sm"
            :class="{ 'text-gray-500': !hasError, 'text-red-500': hasError }"
        >
            <template v-if="errorMessage">
                {{ errorMessage }}
            </template>
            <template v-else>
                <slot name="description" />
            </template>
        </p>
    </div>
</template>
