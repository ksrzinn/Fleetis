<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/inertia-vue3'

const props = defineProps({
    label: String,
    icon: Object,
    href: String,
})

const page = usePage()

</script>

<template>
    <Link
        :href="href"
        class="flex items-center gap-3 px-3 py-2 rounded-md transition"
        :class="isActive
            ? 'bg-blue-600 text-white'
            : 'text-slate-300 hover:bg-white/10'"
    >
        <component :is="icon" class="w-5 h-5" />
        <span class="text-sm font-medium">
            {{ label }}
        </span>
    </Link>
</template>
