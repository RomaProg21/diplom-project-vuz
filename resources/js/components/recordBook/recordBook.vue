<template>

<div class="table-responsive" v-show="stage==1">
        <table width="100%"  class="table table-hover" id="test">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название предмета</th>
                        <th scope="col">Вид контроля</th>
                        <th scope="col">Дата</th>
                        <th scope="col">ФИО преподавателя</th>
                        <th scope="col">Оценка</th>


             


                
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(state,idx) in statement">
                        <td scope="row">{{ idx+1 }}</td>
                        <td >{{ state.predmet.name }}</td>
                        <td >{{ state.vidkontr.name }}</td>
                        <td >{{ state.statement.date }}</td>
                        <td >{{ state.teacher.surname }} {{ state.teacher.name }} {{ state.teacher.patronomic }}</td>
                        <td >{{ state.ocenka.ocenka }}</td>

                   


                      </tr>
        
                    </tbody>
                  </table>
</div>

<div v-if="stage==2 && result!=[]">
    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="date" >Итоговая оценка</label>
      <div class="col-sm-3">
        <input readonly type="text" class="form-control" :value="result[0] ? result[0].ocenka : ''">
      </div>
    </div>
</div>

</template>

<script>
export default{
    props:['statement'],
    data(){
        return{
            stage:1,
            result:null,
        }
    },
    methods:{
        getStatementResult(statement){
            this.stage = 2;
            axios.post('/getStatementResult',{statementId:statement.statement.id}).then(response=>{
                this.result = response.data.result;
            });
        }
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