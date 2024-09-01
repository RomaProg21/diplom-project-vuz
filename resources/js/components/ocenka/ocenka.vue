<template>
<!-- <slot></slot> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css"> -->

<div v-show="etap == 1">

  <!-- <DataTable :data="[[1,2], [3,4]]">
    <table  class="table table-hover">
	<thead>
		<tr>
			<th>A</th>
			<th>B</th>
		</tr>
	</thead>
</table>
</DataTable> -->
  
<div class="table-responsive">
<table  class="table table-hover" width="100%" id="test">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название группы</th>
                        <th scope="col">Факультет</th>

                
                      </tr>
                    </thead>
                    <tbody>
                      <tr @click="GroupStudents(group)" :key="idx" v-for="(group,idx) in result">
                        <th scope="row">{{ idx+1 }}</th>
                        <th >{{ group.group.name }}</th>
                        <td>{{group.fakultet.name}}</td>
                      </tr>
        
                    </tbody>
                  </table>
                </div>
</div>
               
<div v-show="etap==2">

  <div class="d-flex justify-content-end">
      <button class="btn btn-outline-primary" @click="etap=1" type="button">Назад</button>
      </div> 
     
      <div class="table-responsive">
    <table  class="table table-hover" width="100%" id="predmets">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название предмета</th>

                
                      </tr>
                    </thead>
                    <tbody>
                      <tr @click="getStudents(predmet)" v-for="(predmet,idx) in predmets">
                        <th scope="row">{{ idx+1 }}</th>
                        <th >{{ predmet.name }}</th>
                      </tr>
        
                    </tbody>
                  </table>  
                </div>  

</div>

<div v-show="etap == 3">

  <div class="d-flex justify-content-end">
      <button class="btn btn-outline-primary" @click="etap=2" type="button">Назад</button>
      </div> 

<div v-for="mdl in modules" class="d-flex justify-content-center mb-5">
  <button @click="moduleGetOcenka(mdl)" class="btn btn-outline-primary">
      <span>Модуль {{ mdl }}</span>
  </button>
</div>

</div>

<div v-show="etap == 4">


  <div class="d-flex justify-content-end">
      <button class="btn btn-outline-primary" @click="etap=3" type="button">Назад</button>
      </div> 
      <div class="table-responsive">
  <table  class="table table-hover" id="">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Модуль</th>
                        <th scope="col">Балл</th>



                
                      </tr>
                    </thead>
                    <tbody>
                      <tr @click="" v-for="(student,idx) in students">
                        <td scope="row">{{ idx+1 }}</td>
                        <td >{{ student.user[0].surname }} {{ student.user[0].name }} {{ student.user[0].patronomic }}</td>
                        <td >{{ module }}</td>
                        <td ><div class="d-flex"><input class="form-control mr-5" style="width:30%;" type="text" :id="student.student.id" :value="student.student.ocenka ? student.student.ocenka : '' "> <span @click="AddOcenkaStudent(student)" style="width: 30%;border-radius: 10px;" class="btn btn-outline-primary text-center">Сохранить</span></div></td>

                      </tr>
        
                    </tbody>
                  </table>  
                </div>
</div>

</template>

<script>

export default{
    props:['result','predmets','role'],
    components:{
      
    },
    data(){
        return{
            etap:1,
            table:null,
            students:null,
            // predmets:null,
            predmet:null,
            tablePredmets:null,
            ocenka:null,
            group:null,
            modules:null,
            module:null,
        }
    },
    methods:{
        GroupStudents(group){
      
      this.group = group.group;
            axios.post('/getStudents',{idGroup:group.group.id}).then(response=>{
                this.students = response.data.students;
                this.etap = 2;
    //             axios.post('/allPredmets').then(response=>{
    //                 this.predmets = response.data.predmets;
             

    // this.etap = 2;
    //             });
            });
        },
        getStudents(predmet){
            this.etap = 3;
            this.predmet = predmet;
            axios.post('/getModulesPredmets',{predmet:predmet}).then(response=>{
            this.modules = Number(response.data.result[0].module);  
            });
        },
        moduleGetOcenka(module){
          axios.post('/getStudents',{idGroup:this.group.id}).then(response=>{
                this.students = response.data.students;


                this.module = module;
          this.etap = 4;
          axios.post('/getOcenka',{module:module,predmet:this.predmet,group:this.group}).then(response=>{
            this.ocenka = response.data.result;
            this.students.map((stud)=>{
              this.ocenka.filter((el)=>{
                if(el.stud_id ==stud.student.id){
                  stud.student.ocenka = el.ocenka;
                } 
              })
            });
        
          });
            });
           

       
        },  
        AddOcenkaStudent(student){
          let ball = document.getElementById(student.student.id).value;
          axios.post('/addOcenkaStudent',{module:this.module,student:student,ball:ball,predmet:this.predmet}).then(response=>{
            alert(response.data.result);
          });
        },
        
    },
    mounted(){
       this.table = new DataTable('#test', {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/ru.json',
        },
    });

    new DataTable('#predmets', {
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/ru.json',
        },
    });
    

    },
}
</script>