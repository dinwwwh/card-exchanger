<script setup>
import Header from '../Components/Headers';
import Footer from '../Components/Footers';
</script>

<template>
    <div class="bg-gray-50">
        <Header class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8" />

        <main class="mt-12 max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <slot />
        </main>

        <Footer class="mt-16" />
    </div>
</template>
