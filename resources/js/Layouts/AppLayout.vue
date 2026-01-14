<script setup>

import Topbar from '../Components/Layout/Topbar.vue';
import Sidebar from '../Components/Layout/Sidebar.vue';
</script>

<template>
    <div class="min-h-screen flex bg-[var(--color-bg-app)]">
        <Sidebar />

        <div class="flex-1 flex flex-col">
            <Topbar :user="user"/>
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AppLayout',
    props: {
        user: {
            type: Object,
            required: true
        }
    }
}
</script>
