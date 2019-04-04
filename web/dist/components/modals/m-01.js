Vue.component('m-01',{
    template: '#m-01-template',
    props:{
        modal: String,
        successfulResponse: Boolean,
        email: String,
    },
    mounted: function () {
        $('#m-01').on('hide.bs.modal', () => {
            this.$emit('hide')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-01'){
                $('#m-01').modal('show')
            } else{
                $('#m-01').modal('hide')
            }
        }
    },
    methods:{
        sendEmailAgain(){
            registerForm.showModal('m-03')
        },
    }
})