Vue.component('m-00-2', {
    template: '#m-00-2-template',
    props: {
        modal: String,
    },
    mounted: function () {
        $('#m-00-2').on('hide.bs.modal', () => {
            this.$emit('hide')
        })
    },
    watch: {
        modal(newVal, oldVal) {
            if (newVal === 'm-00-2') {
                $('#m-00-2').modal('show')
            } else {
                $('#m-00-2').modal('hide')
            }
        }
    }
})