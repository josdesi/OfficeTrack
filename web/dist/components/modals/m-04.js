Vue.component('m-04',{
    template: '#m-04-template',
    props:{
        modal: String,
        email: String,
    },
    mounted: function () {
        $('#m-04').on('hide.bs.modal', () => {
            this.$emit('hide','m-04')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-04'){
                $('#m-04').modal('show')
            } else {
                $('#m-04').modal('hide')
            }
        }
    },    
    methods:{
        sendEmailAgain(){
            this.$emit('link-click', 'm-03')
        },
    }
})