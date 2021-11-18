<script setup>
import Header from '~/Components/Header';
import Footer from '~/Components/Footer';
</script>

<template>
    <div class="bg-gray-100">
        <div class="bg-gradient-to-r from-sky-800 to-cyan-600">
            <Header class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 pb-24" />

            <main class="-mt-24 max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>

        <Footer class="mt-16" />
    </div>
</template>
