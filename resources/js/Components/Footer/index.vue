<script setup>
import { ref } from '@vue/reactivity';
import { Facebook } from '../icons';

const navigation = [
    {
        name: 'Facebook',
        href: '#',
        icon: Facebook,
    },
];
</script>

<template>
    <footer class="bg-white">
        <div
            class="
                max-w-7xl
                mx-auto
                py-12
                px-4
                sm:px-6
                md:flex md:items-center md:justify-between
                lg:px-8
            "
        >
            <div class="flex justify-center space-x-6 md:order-2">
                <a
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    class="text-gray-400 hover:text-gray-500"
                >
                    <span class="sr-only">{{ item.name }}</span>
                    <component
                        :is="item.icon"
                        class="h-6 w-6"
                        aria-hidden="true"
                    />
                </a>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-center text-base text-gray-400">
                    © 2021, Made by
                    <a
                        href="https://dinhdjj.com"
                        target="_blank"
                        class="text-indigo-500 tracking-wider"
                    >
                        @dinhdjj
                    </a>
                </p>
            </div>
        </div>
    </footer>
</template>
