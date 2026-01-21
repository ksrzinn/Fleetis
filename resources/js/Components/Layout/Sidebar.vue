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

            <SidebarItem
                label="Motoristas"
                :icon="List"
                href="/drivers"
            />

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
