<template>


<div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="prepodavatel" >Преподаватель</label>
                 
                    <div class="col-sm-5">
                        <input  placeholder="Поиск" type="text" class="form-control mb-3" v-model="searchTeacher">
                        <select name="prepodavatel" class="form-select" id="">
                            <option v-for="prepodavatel in filteredData()" :value="prepodavatel.prepod.id">{{prepodavatel['user'].surname}} {{prepodavatel.user.name}} {{prepodavatel.user.patronomic}} ({{prepodavatel.user.email}})</option>
                        </select>
                    </div>
                  </div>

</template>

<script>
export default{
    props:['prepodArrayAll'],
    data(){
        return{
            searchTeacher:'',
        }
    },
    methods:{
        filteredData() {
          if(this.prepodArrayAll.length>0){
          return this.prepodArrayAll.filter(row => {
            return Object.values(row.user).some(value => {
              return String(value).toLowerCase().includes(this.searchTeacher.toLowerCase());
            });
          });
        }
        },
    },
    mounted(){
    }

}
</script>