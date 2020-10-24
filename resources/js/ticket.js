const { default: Axios } = require("axios")

const app = new Vue({
    el:'#ticket',
    data:{

        selected_department:'',
        selected_subarea:'',
        subareas:[],
        selected_activity:'',
        activities:[],
    },
    methods:{

        loadSubareas(){
            axios.get('subareas', {params:{idDepartment:this.selected_department}}).then((response) =>{
                this.subareas = response.data;
            });
        },

        loadActivities(){
            axios.get('activities', {params:{idSubarea:this.selected_subarea}}).then((response) =>{
                this.activities = response.data;
            });
        }
    }
})