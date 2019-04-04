Vue.component('m-00', {
    template: '#m-00-template',
    props: {
        modal: String,
    },
    mounted: function () {
        $('#m-00').on('hide.bs.modal', () => {
            this.$emit('hide')
        })
    },
    watch: {
        modal(newVal, oldVal) {
            if (newVal === 'm-00') {
                $('#m-00').modal('show')
            } else {
                $('#m-00').modal('hide')
            }
        }
    }
})