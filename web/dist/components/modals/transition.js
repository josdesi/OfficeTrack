Vue.component('transition',{
    template: '#transition-template',
    props:{
        modal: String,
        email: String,
    },
    mounted: function () {
        $('#transition').on('hide.bs.modal', () => {
            this.$emit('hide','transition')
        })
    },
    watch:{
        modal(newVal,oldVal){
            if(newVal === 'transition'){
                $('#transition').modal('show')
            } else {
                $('#transition').modal('hide')
            }
        }
    },    
    methods:{
        sendEmailAgain(){
            this.$emit('link-click', 'm-03')
        },
    }
})