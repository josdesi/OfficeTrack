Vue.component('m-03',{
    template: '#m-03-template',
    props:{
        modal: String,
    },
    mounted: function () {
        $('#m-03').on('hide.bs.modal', () => {
            this.$emit('hide','m-03')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-03'){
                $('#m-03').modal('show')
            } else {
                $('#m-03').modal('hide')
            }
        }
    },
})