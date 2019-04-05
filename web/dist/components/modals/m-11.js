Vue.component('m-11',{
    template: '#m-11-template',
    props:{
        modal: String,
        email: String,
    },
    mounted: function () {
        $('#m-11').on('hide.bs.modal', () => {
            this.$emit('hide','m-11')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-11'){
                $('#m-11').modal('show')
            } else {
                $('#m-11').modal('hide')
            }
        }
    },    
    methods:{
        sendEmailAgain(){
            this.$emit('link-click', 'm-03')
        },
    }
})