Vue.component('m-12',{
    template: '#m-12-template',
    props:{
        modal: String,
        email: String,
    },
    mounted: function () {
        $('#m-12').on('hide.bs.modal', () => {
            this.$emit('hide','m-12')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-12'){
                $('#m-12').modal('show')
            } else {
                $('#m-12').modal('hide')
            }
        }
    },    
    methods:{
        sendEmailAgain(){
            this.$emit('link-click', 'm-03')
        },
    }
})