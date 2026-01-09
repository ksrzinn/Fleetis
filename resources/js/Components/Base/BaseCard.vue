<template>
    <div
        class="bg-white rounded-xl border shadow-sm"
        style="border-color: var(--color-border)"
    >
        <!-- Header -->
        <div
            v-if="title || $slots.header"
            class="px-6 py-4 border-b"
            style="border-color: var(--color-border)"
        >
            <slot name="header">
                <h2 class="text-lg font-semibold text-slate-800">
                    {{ title }}
                </h2>
            </slot>
        </div>

        <!-- Body -->
        <div :class="padding">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    name: 'BaseCard',

    props: {
        title: {
            type: String,
            default: null,
        },
        padding: {
            type: String,
            default: 'p-6',
        },
    },
}
</script>
