Vue.component('m-09',{
    template: '#m-09-template',
    props:{
        modal: String,
        email: String,
    },
    mounted: function () {
        $('#m-09').on('hidden.bs.modal', function(e) {
            this.$emit('hide','m-09')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'm-09'){
                $('#m-09').modal('show')
            } else {
                $('#m-09').modal('hide')
            }
        }
    },    
    methods:{
        sendEmailAgain(){
            this.$emit('link-click', 'm-03')
        },
    }
})