<template>
    <input  class="form-control pickadate" v-bind:value="value"
            @input="updateValue($event.target.value)" ref="input">
</template>

<script>
    export default {
        props: {
            'value':{ default: '' }, 
            'format': { default:'yyyy-mm-dd' },
            'formatSubmit': { default:'yyyy-mm-dd'} ,
            'selectYears': { default:20} ,
            'selectMonths': { default:true },
            'closeOnSelect': { default:true }
        },
        data: function() {
            return {
                picker: null
            }
        },
        methods: {
            updateValue(value) {
                // Atttach validation + sanitization here.
                this.$emit('input', value);
            }
        },
        mounted: function() {
            this.picker = $(this.$el).pickadate().pickadate('picker');
        },
        beforeDestroy: function() {
            this.picker.stop();
        }
    }
</script>