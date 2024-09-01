<template>

<div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="name_predmet" >Предмет</label>
                    <div class="col-sm-5">
                        <input placeholder="Поиск" type="text" class="form-control mb-3" v-model="searchPredmet">
                        <select name="name_predmet" class="form-select" id="">
                            <option v-for="predmet in filterPredmets()" :value="predmet.id">{{predmet.name}}</option>
                        </select>
                    </div>
                  </div>

                  <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="group_name" >Группа</label>
                    <div class="col-sm-5">  
                        <input placeholder="Поиск" type="text" class="form-control mb-3" v-model="searchGroup">
                        <select name="group_name" class="form-select" id="">
                            <option v-for="group in filterGroups()" :value="group.id">{{group.name}}</option>
                        </select>
                    </div>
                  </div>

</template>
    
    <script>
    export default{
        props:['allPredmets','groups'],
        data(){
            return{
                searchPredmet:'',
                searchGroup:'',
            }
        },
        methods:{
            filterPredmets() {
              if(this.allPredmets.length>0){
              return this.allPredmets.filter(row => {
                return Object.values(row).some(value => {
                  return String(value).toLowerCase().includes(this.searchPredmet.toLowerCase());
                });
              });
            }
            },
            filterGroups() {
              if(this.groups.length>0){
              return this.groups.filter(row => {
                return Object.values(row).some(value => {
                  return String(value).toLowerCase().includes(this.searchGroup.toLowerCase());
                });
              });
            }
            },
            
        },
        mounted(){
        }
    
    }
    </script>