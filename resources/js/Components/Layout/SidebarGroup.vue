<template>
    <div>
        <!-- Item principal -->
        <button
            type="button"
            @click="toggle"
            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sidebarText hover:bg-sidebarHover transition"
        >
            <div class="flex items-center gap-3">
                <component :is="icon" class="w-5 h-5" />
                <span>{{ label }}</span>
            </div>

            <!-- seta -->
            <svg
                class="w-4 h-4 transition-transform"
                :class="{ 'rotate-90': isOpen }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </button>

        <!-- Sublista -->
        <transition name="sidebar-slide">
            <div
                v-show="isOpen"
                class="ml-6 mt-1 space-y-1"
            >
                <slot />
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    name: 'SidebarGroup',

    props: {
        label: {
            type: String,
            required: true,
        },
        icon: {
            type: Function,
            required: true,
        },
    },

    data() {
        return {
            isOpen: false,
        }
    },

    methods: {
        toggle() {
            this.isOpen = !this.isOpen
        },
    },
}
</script>

<style scoped>
.sidebar-slide-enter-active,
.sidebar-slide-leave-active {
    transition: all 0.2s ease;
}

.sidebar-slide-enter-from,
.sidebar-slide-leave-to {
    opacity: 0;
    max-height: 0;
}

.sidebar-slide-enter-to,
.sidebar-slide-leave-from {
    opacity: 1;
    max-height: 300px;
}
</style>
