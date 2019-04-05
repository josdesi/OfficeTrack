Vue.component('m-08',{
    template: '#m-08-template',
    props:{
        modal: String,
        email: String,
    },
    mounted: function () {
        $('#m-08').on('hide.bs.modal', () => {
            this.$emit('hide','m-08')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-08'){
                $('#m-08').modal('show')
            } else {
                $('#m-08').modal('hide')
            }
        }
    },    
    methods:{
        sendEmailAgain(){
            this.$emit('link-click', 'm-03')
        },
    }
})