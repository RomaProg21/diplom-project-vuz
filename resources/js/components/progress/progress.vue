<template>
    <div class="table-responsive" v-show="stage==1">
        <table width="100%"  class="table table-hover" id="test">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название предмета</th>
             


                
                      </tr>
                    </thead>
                    <tbody>
                      <tr @click="getModules(predmet)" v-for="(predmet,idx) in result">
                        <td scope="row">{{ idx+1 }}</td>
                        <td >{{ predmet.predmet.name }}</td>
                   


                      </tr>
        
                    </tbody>
                  </table>
</div>
<div v-show="stage==2">
<div  v-for="mdl in modules" class="d-flex justify-content-center mb-5">
  <button @click="getOcenkaForStudent(mdl)" class="btn btn-outline-primary">
      <span>Модуль {{ mdl }}</span>
  </button>
</div>
</div>
<div v-if="stage==3 && ocenka!=[]">
    <div>Дата: {{ ocenka[0] ? ocenka[0].date : '' }}</div>
    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="date" >Балл</label>
      <div class="col-sm-3">
        <input readonly type="text" class="form-control" :value="ocenka[0] ? ocenka[0].ocenka : ''">
      </div>
    </div>
</div>
</template>

<script>
export default{
    props:['result'],
    data(){
        return{
            modules:null,
            stage:1,
            predmet:null,
            ocenka:[],
        }
    },
    methods:{
        getModules(predmet){
            this.predmet = predmet.predmet;
            this.stage = 2;
            axios.post('/getModulesPredmets',{predmet:predmet.predmet.id}).then(response=>{
                console.log(response.data.result);
            this.modules = Number(response.data.result[0].module);  
            });
        },
        getOcenkaForStudent(mdl){
            this.stage = 3;
            axios.post('/getModuleOcenkaForStudent',{predmet:this.predmet,module:mdl}).then(response=>{
                this.ocenka = response.data.ocenka;
            })
        },
    },
    mounted(){
        new DataTable('#test', {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/ru.json',
        },
    });
    }
}
</script>