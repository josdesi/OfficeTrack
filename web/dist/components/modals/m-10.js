Vue.component('m-10',{
    template: '#m-10-template',
    props:{
        modal: String,
        email: String,
    },
    mounted: function () {
        $('#m-10').on('hide.bs.modal', () => {
            this.$emit('hide','m-10')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-10'){
                $('#m-10').modal('show')
            } else {
                $('#m-10').modal('hide')
            }
        }
    },    
    methods:{
        sendEmailAgain(){
            this.$emit('link-click', 'm-03')
        },
    }
})