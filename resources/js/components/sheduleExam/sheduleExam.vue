<template>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css"> -->

<div v-if="role==1">
<h5 class="text-center mb-5">Добавить экзамен в расписание</h5>
<div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="group" >Выберите группу</label>
      <div class="col-sm-5">
        <input  placeholder="Поиск" type="text" class="form-control mb-3" v-model="searchGroup">

        <select  class="form-select" name="group" aria-label="Default select example">
            <option v-for="group in filterGroup()" :value="group.id">{{ group.name }}</option>
        </select>
      </div>
    </div>

<div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="predmet" >Выберите предмет</label>
      <div class="col-sm-5">
        <input  placeholder="Поиск" type="text" class="form-control mb-3" v-model="searchPredmet">

        <select  class="form-select" name="predmet" aria-label="Default select example">
            <option v-for="predmet in filterPredmet()" :value="predmet.id">{{ predmet.name }}</option>
        </select>
      </div>
    </div>

  

    
    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="date" >Дата</label>
      <div class="col-sm-5">
        <input required type="datetime-local" class="form-control" name="date">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="kabinet" >Кабинет</label>
      <div class="col-sm-5">
        <input required type="text" class="form-control" name="kabinet">
      </div>
    </div>

    
    <div class="d-flex justify-content-end mb-5">
    <button class="btn btn-outline-primary" type="submit">Создать</button>
    </div>
    
  </div>
<div>

<table width="100%"  class="table table-hover" id="test">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название группы</th>
                        <th scope="col">Название предмета</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Кабинет</th>


                
                      </tr>
                    </thead>
                    <tbody>
                      <tr @click="" v-for="(exam,idx) in result">
                        <td scope="row">{{ idx+1 }}</td>
                        <td >{{ exam.group.name }}</td>
                        <td>{{exam.predmet.name}}</td>
                        <td>{{exam.shedule.date}}</td>
                        <td>{{exam.shedule.kabinet}}</td>


                      </tr>
        
                    </tbody>
                  </table>

                  

</div>


</template>

<script>


export default{
    props:['groupall','allpredmet','result','role'],
    data(){
        return{
          searchGroup:'',
          searchPredmet:'',
        }
    },
    methods:{

      filterGroup() {
          if(this.groupall.length>0){
          return this.groupall.filter(row => {
            return Object.values(row).some(value => {
              return String(value).toLowerCase().includes(this.searchGroup.toLowerCase());
            });
          });
        }
        },
        filterPredmet() {
          if(this.allpredmet.length>0){
          return this.allpredmet.filter(row => {
            return Object.values(row).some(value => {
              return String(value).toLowerCase().includes(this.searchPredmet.toLowerCase());
            });
          });
        }
        },
      
    },
    mounted(){

        this.table = new DataTable('#test', {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/ru.json',
        },
    });

   

    },
}
</script>