<template>
    <div class="flex flex-col gap-1">
        <label
            v-if="label"
            class="text-sm font-medium text-slate-700"
        >
            {{ label }}
        </label>

        <input
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :readonly="readonly"
            :class="inputClasses"
            @input="updateValue"
        />

        <span
            v-if="error"
            class="text-xs text-red-500"
        >
            {{ error }}
        </span>
    </div>
</template>

<script>
export default {
    name: 'BaseInput',

    props: {
        modelValue: {
            type: [String, Number],
            default: '',
        },

        label: {
            type: String,
            default: '',
        },

        type: {
            type: String,
            default: 'text',
        },

        placeholder: {
            type: String,
            default: '',
        },

        error: {
            type: String,
            default: null,
        },

        disabled: {
            type: Boolean,
            default: false,
        },

        readonly: {
            type: Boolean,
            default: false,
        },
    },

    emits: ['update:modelValue'],

    computed: {
        inputClasses() {
            return [
                'w-full rounded-lg border px-3 py-2 text-sm',
                'focus:outline-none focus:ring-2',
                this.error
                    ? 'border-red-500 focus:ring-red-300'
                    : 'border-slate-300 focus:ring-blue-300',
                this.disabled && 'bg-slate-100 cursor-not-allowed',
            ]
        },
    },

    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.target.value)
        },
    },
}
</script>
