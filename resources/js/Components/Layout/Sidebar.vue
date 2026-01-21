<template>
    <aside class="w-64 min-h-screen px-4 py-6 bg-sidebarBg">
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

            <SidebarGroup
                label="Fretes"
                :icon="Container"
            >
                <SidebarGroup
                    label="Fretes Fixos"
                    :icon="Container"
                >

                    <SidebarItem
                        label="Valores dos fretes fixos"
                        :icon="List"
                        href="/freights/fixedFreights/"
                    />

                </SidebarGroup>

                <SidebarGroup
                    label="Fretes Por KM"
                    :icon="Container"
                >
                    <SidebarItem
                        label="Cadastro de tarifa do KM"
                        :icon="List"
                        href="/freights/per-km/create"
                    />

                </SidebarGroup>

                <SidebarItem
                    label="Novo Frete"
                    :icon="Plus"
                    href="/freights/create"
                />
            </SidebarGroup>

            <SidebarGroup
                label="Veículos"
                :icon="Truck"
            >
                <SidebarItem
                    label="Tipos de veículos"
                    :icon="List"
                    href="/vehicleTypes"
                />
            </SidebarGroup>
            <!-- SVG manual de motorista -->
            <a href="/drivers"class="flex items-center gap-3 px-3 py-2 rounded-lg text-sidebarText hover:bg-sidebarHover transition">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    >
                    <!-- Cabeça -->
                    <circle cx="9" cy="7" r="3" />

                    <!-- Corpo -->
                    <path d="M3 21v-1a6 6 0 0 1 12 0v1" />

                    <!-- Volante -->
                    <circle cx="17" cy="15" r="4" />
                    <path d="M17 13v2" />
                    <path d="M15.3 16l1.7-1" />
                    <path d="M18.7 16l-1.7-1" />
                </svg>

                <span>Motoristas</span>
            </a>

            <SidebarItem
                label="Financeiro"
                :icon="Wallet"
                href="/financial"
            />
        </nav>
    </aside>
</template>

<script>
import SidebarItem from './SidebarItem.vue'
import SidebarGroup from './SidebarGroup.vue'

import {
    LayoutDashboard,
    Truck,
    Wallet,
    List,
    Plus,
    Container
} from 'lucide-vue-next'

export default {
    name: 'Sidebar',

    components: {
        SidebarItem,
        SidebarGroup,
    },

    data() {
        return {
            LayoutDashboard,
            Truck,
            Wallet,
            List,
            Plus,
            Container
        }
    },
}
</script>
