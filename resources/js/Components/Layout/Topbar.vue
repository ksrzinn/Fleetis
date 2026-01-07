<template>
    <header
        class="h-16 bg-white border-b flex items-center justify-between px-6"
    >
        <span class="font-medium text-slate-700">
            {{ title }}
        </span>

        <div class="text-sm text-slate-600">Usuário</div>
    </header>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: "Dashboard",
    },
});
</script>
