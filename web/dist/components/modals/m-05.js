Vue.component('m-05',{
    template: '#m-05-template',
    props:{
        modal: String,
        email: String,
    },
    mounted: function () {
        $('#m-05').on('hide.bs.modal', () => {
            this.$emit('hide','m-05')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-05'){
                $('#m-05').modal('show')
            } else {
                $('#m-05').modal('hide')
            }
        }
    },    
    methods:{
        sendEmailAgain(){
            this.$emit('link-click', 'm-03')
        },
    }
})