<template>
    <button
        :type="type"
        :disabled="isDisabled"
        class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-md font-medium transition focus:outline-none"
        :class="[
            variantClasses,
            isDisabled ? 'opacity-60 cursor-not-allowed' : ''
        ]"
    >
        <!-- Loading -->
        <svg
            v-if="loading"
            class="animate-spin h-4 w-4"
            viewBox="0 0 24 24"
        >
            <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
                fill="none"
            />
            <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z"
            />
        </svg>

        <slot />
    </button>
</template>

<script>
export default {
    name: 'BaseButton',

    props: {
        type: {
            type: String,
            default: 'button',
        },

        variant: {
            type: String,
            default: 'primary', // primary | secondary | danger | ghost
        },

        loading: {
            type: Boolean,
            default: false,
        },

        disabled: {
            type: Boolean,
            default: false,
        },
    },

    computed: {
        isDisabled() {
            return this.disabled || this.loading
        },

        variantClasses() {
            const variants = {
                primary: 'bg-blue-600 hover:bg-blue-700 text-white',
                secondary: 'bg-slate-100 hover:bg-slate-200 text-slate-800',
                danger: 'bg-red-600 hover:bg-red-700 text-white',
                ghost: 'bg-transparent hover:bg-slate-100 text-slate-700',
            }

            return variants[this.variant] || variants.primary
        },
    },
}
</script>
