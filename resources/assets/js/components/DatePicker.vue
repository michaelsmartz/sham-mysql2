<template>
    <input type="text"
        v-bind:value="value"
        @input="updateValue($event.target.value)"
        ref="input">
</template>

<script>
export default {
    methods: {
        updateValue(value) {
            // Atttach validation + sanitization here.
            this.$emit('input', value);
        }
    },
    props: {
        'value':{ default: ''}, 
        'dateFormat':{ default: 'yy-mm-dd'}, 
        'changeMonth':{ default: true},
        'changeYear':{ default: true}

    },
    mounted: function () {
        $(this.$el).datepicker({
            showButtonPanel: true,
            changeMonth: this.changeMonth,
            changeYear: this.changeYear,
            dateFormat: this.dateFormat,
            onSelect: function (date) {
                this.$emit('update-date', date);
            }
        });
        +function ($, el) {
            var self = this;

        }(jQuery, this);
    }
}
</script>
