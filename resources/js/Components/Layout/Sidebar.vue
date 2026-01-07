<template>
    <aside class="w-64 bg-slate-900 text-slate-100 flex flex-col">
        <div
            class="h-16 flex items-center justify-center border-b border-slate-800"
        >
            <span class="text-lg font-semibold">Fleetis</span>
            <!-- logo depois -->
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <SidebarItem label="Dashboard" to="/dashboard" />

            <SidebarItem label="Fretes & KM" />
            <SidebarItem label="Financeiro" disabled />
        </nav>
    </aside>
</template>
