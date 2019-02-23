<template>
    <transition name="modal">
        <div class="light-modal" role="dialog" aria-labelledby="light-modal-label" aria-hidden="false">
            <div class="light-modal-content large-content animated fadeIn">
                <div class="light-modal-header">
                    <h3 class="light-modal-heading" v-text="header"></h3>
                    <a href="#" class="light-modal-close-icon" aria-label="close">&times;</a>
                </div>
                <div class="light-modal-body">
                    Change the status for {{ body }}
                </div>
                <div class="light-modal-footer">{{ footer }}</div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props:{
            'header':{ default: ''}, 
            'body':{ default: ''}, 
            'footer':{ default: ''}
        }
    }
</script>