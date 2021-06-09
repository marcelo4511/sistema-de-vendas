<template>

    <div class="modal fade m-3" role="dialog" :id="name">
        <div class="modal-dialog modal-dialog-top" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }} <b>{{compl}}</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <slot></slot>
            </div>
        </div>
        
    </div>

</template>

<script>
export default {
    props: ['name', 'title','compl'],
}
</script>

<style>

</style>