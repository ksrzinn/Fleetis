<template>
    <a
        :href="href"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sidebarText hover:bg-sidebarHover transition"
    >
        <component
            v-if="icon"
            :is="icon"
            class="w-5 h-5"
        />
        <span>{{ label }}</span>
    </a>
</template>

<script>
export default {
    name: 'SidebarItem',

    props: {
        label: String,
        icon: Function,
        href: String,
    },
}
</script>
