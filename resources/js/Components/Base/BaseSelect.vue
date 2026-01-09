<template>
    <div ref="wrapper" class="relative flex flex-col gap-1 w-full">
        <label
            v-if="label"
            class="text-sm font-medium text-gray-700"
        >
            {{ label }}
        </label>

        <!-- Input / Search -->
        <input
            ref="input"
            v-model="search"
            type="text"
            :placeholder="placeholder"
            :disabled="disabled"
            class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm
                   focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500
                   disabled:bg-gray-100 disabled:cursor-not-allowed"
            @focus="open = true"
            @keydown.down.prevent="highlightNext"
            @keydown.up.prevent="highlightPrev"
            @keydown.enter.prevent="selectHighlighted"
        />

        <!-- Dropdown -->
        <div
            v-if="open"
            class="absolute z-50 top-full mt-1 w-full rounded-md border border-gray-200 bg-white shadow-lg"
        >
            <ul class="max-h-48 overflow-y-auto">
                <li
                    v-for="(option, index) in filteredOptions"
                    :key="option[optionValue]"
                    class="cursor-pointer px-3 py-2 text-sm"
                    :class="{
                        'bg-primary-50': index === highlightedIndex,
                        'hover:bg-primary-50': true
                    }"
                    @mousedown.prevent="select(option)"
                >
                    {{ option[optionLabel] }}
                </li>

                <li
                    v-if="filteredOptions.length === 0"
                    class="px-3 py-2 text-sm text-gray-400"
                >
                    Nenhum resultado
                </li>
            </ul>
        </div>

        <p v-if="error" class="text-sm text-red-600">
            {{ error }}
        </p>
    </div>
</template>

<script>
    export default {
    name: 'BaseSelect',

    props: {
        modelValue: {
            required: true,
        },
        options: {
            type: Array,
            default: () => [],
        },
        optionLabel: {
            type: String,
            default: 'label',
        },
        optionValue: {
            type: String,
            default: 'value',
        },
        label: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: 'Selecione',
        },
        error: {
            type: String,
            default: '',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },

    emits: ['update:modelValue'],

    data() {
        return {
            open: false,
            search: '',
            highlightedIndex: -1,
        };
    },

    computed: {
        selectedOption() {
            return this.options.find(
                option => option[this.optionValue] === this.modelValue
            );
        },

        filteredOptions() {
            if (!this.search) return this.options;

            return this.options.filter(option =>
                String(option[this.optionLabel])
                    .toLowerCase()
                    .includes(this.search.toLowerCase())
            );
        },
    },

    watch: {
        selectedOption: {
            immediate: true,
            handler(option) {
                if (option) {
                    this.search = option[this.optionLabel];
                }
            },
        },
    },

    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    },

    beforeUnmount() {
        document.removeEventListener('click', this.handleClickOutside);
    },

    methods: {
        select(option) {
            this.$emit('update:modelValue', option[this.optionValue]);
            this.search = option[this.optionLabel];
            this.open = false;
            this.highlightedIndex = -1;
        },

        handleClickOutside(event) {
            if (!this.$refs.wrapper.contains(event.target)) {
                this.open = false;
                this.highlightedIndex = -1;
            }
        },

        highlightNext() {
            if (!this.open) this.open = true;
            if (this.highlightedIndex < this.filteredOptions.length - 1) {
                this.highlightedIndex++;
            }
        },

        highlightPrev() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex--;
            }
        },

        selectHighlighted() {
            if (this.highlightedIndex >= 0) {
                this.select(this.filteredOptions[this.highlightedIndex]);
            }
        },
    },
};

</script>
