<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
import { MenuIcon, XIcon } from '@heroicons/vue/outline';
import { ref } from '@vue/reactivity';

const navigation = ref([
    { name: 'Changelog', href: '#' },
    { name: 'About', href: '#' },
    { name: 'Partners', href: '#' },
    { name: 'News', href: '#' },
]);

const logoUrl =
    'https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=500';
</script>

<template>
    <Popover as="header" class="relative">
        <nav
            class="
                relative
                max-w-7xl
                mx-auto
                flex
                items-center
                justify-between
                pt-6
            "
            aria-label="Global"
        >
            <div class="flex items-center flex-1">
                <div class="flex items-center justify-between w-full lg:w-auto">
                    <a href="#">
                        <span class="sr-only">Workflow</span>
                        <img class="h-8 w-auto sm:h-10" :src="logoUrl" alt="" />
                    </a>
                    <div class="-mr-2 flex items-center lg:hidden">
                        <PopoverButton
                            class="
                                bg-gray-50
                                rounded-md
                                p-2
                                inline-flex
                                items-center
                                justify-center
                                text-gray-400
                                hover:bg-gray-100
                                focus:outline-none
                                focus:ring-2
                                focus-ring-inset
                                focus:ring-indigo-500
                            "
                        >
                            <span class="sr-only">Open main menu</span>
                            <MenuIcon class="h-6 w-6" aria-hidden="true" />
                        </PopoverButton>
                    </div>
                </div>
                <div class="hidden space-x-10 lg:flex lg:ml-10">
                    <a
                        v-for="item in navigation"
                        :key="item.name"
                        :href="item.href"
                        class="
                            text-base
                            font-medium
                            text-gray-500
                            hover:text-gray-900
                        "
                        >{{ item.name }}</a
                    >
                </div>
            </div>
            <div class="hidden lg:flex lg:items-center lg:space-x-6">
                <a
                    href="#"
                    class="
                        py-2
                        px-6
                        bg-gray-100
                        border border-transparent
                        rounded-md
                        text-base
                        font-medium
                        text-gray-900
                        hover:bg-gray-200
                    "
                >
                    Đăng nhập
                </a>
            </div>
        </nav>

        <transition
            enter-active-class="duration-150 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="duration-100 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <PopoverPanel
                focus
                class="
                    absolute
                    z-30
                    top-0
                    inset-x-0
                    p-2
                    transition
                    transform
                    origin-top
                    lg:hidden
                "
            >
                <div
                    class="
                        rounded-lg
                        shadow-lg
                        bg-white
                        ring-1 ring-black ring-opacity-5
                        overflow-hidden
                    "
                >
                    <div class="px-5 pt-4 flex items-center justify-between">
                        <div>
                            <img
                                class="h-8 w-auto"
                                src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=500"
                                alt=""
                            />
                        </div>
                        <div class="-mr-2">
                            <PopoverButton
                                class="
                                    bg-white
                                    rounded-md
                                    p-2
                                    inline-flex
                                    items-center
                                    justify-center
                                    text-gray-400
                                    hover:bg-gray-100
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-inset
                                    focus:ring-indigo-500
                                "
                            >
                                <span class="sr-only">Close menu</span>
                                <XIcon class="h-6 w-6" aria-hidden="true" />
                            </PopoverButton>
                        </div>
                    </div>
                    <div class="pt-5 pb-6">
                        <div class="px-2 space-y-1">
                            <a
                                v-for="item in navigation"
                                :key="item.name"
                                :href="item.href"
                                class="
                                    block
                                    px-3
                                    py-2
                                    rounded-md
                                    text-base
                                    font-medium
                                    text-gray-900
                                    hover:bg-gray-50
                                "
                                >{{ item.name }}</a
                            >
                        </div>
                        <div class="mt-6 px-5">
                            <a
                                href="#"
                                class="
                                    block
                                    text-center
                                    w-full
                                    py-2
                                    px-4
                                    border border-transparent
                                    rounded-md
                                    shadow
                                    bg-indigo-500
                                    text-white
                                    font-medium
                                    hover:bg-indigo-600
                                "
                            >
                                Đăng nhập
                            </a>
                        </div>
                    </div>
                </div>
            </PopoverPanel>
        </transition>
    </Popover>
</template>
