<script setup>

import Topbar from '../Components/Layout/Topbar.vue';
import Sidebar from '../Components/Layout/Sidebar.vue';
</script>

<template>
    <div class="flex h-screen bg-appBg">
        <!-- Sidebar -->
        <Sidebar />

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Topbar -->
            <Topbar />

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
