<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import UserMenu from './UserMenu.vue'

const page = usePage()

const pageTitle = computed(() => {
    return page.props?.title || 'Dashboard'
})
</script>

<template>
    <header
        class="h-16 px-6 flex items-center justify-between bg-white border-b"
        style="border-color: var(--color-border)"
    >
        <!-- Left: Page title -->
        <div class="text-lg font-semibold text-slate-800">
            {{ pageTitle }}
        </div>

        <!-- Right: User -->
        <UserMenu :user="user" />
    </header>
</template>

<script>
export default {
    name: 'Topbar',
    props: {
        user: {
            type: Object,
            required: true
        }
    }
}
</script>
