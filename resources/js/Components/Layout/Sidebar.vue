<script setup>
import SidebarItem from './SidebarItem.vue'

import {
    LayoutDashboard,
    Truck,
    Wallet
} from 'lucide-vue-next'
</script>

<template>
    <aside
        class="w-64 min-h-screen px-4 py-6 bg-sidebarBg"
    >
        <!-- Header -->
        <div class="mb-8 text-white text-xl font-semibold">
            Fleetis
        </div>

        <!-- Menu -->
        <nav class="space-y-1">
            <SidebarItem
                label="Dashboard"
                :icon="LayoutDashboard"
                href="/dashboard"
            />

            <SidebarItem
                label="Fretes"
                :icon="Truck"
                href="/freights"
            />

            <SidebarItem
                label="Financeiro"
                :icon="Wallet"
                href="/financial"
            />
        </nav>
    </aside>
</template>
