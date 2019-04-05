Vue.component('m-02',{
    template: '#m-02-template',
    props:{
        modal: String,
    },
    mounted: function () {
        $('#m-02').on('hide.bs.modal', () => {
            this.$emit('hide')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-02'){
                $('#m-02').modal('show')
            } else{
                $('#m-02').modal('hide')
            }
        }
    },
})