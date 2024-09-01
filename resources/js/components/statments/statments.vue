
<template>
  <div v-if="stage==4">
    <div id="printMe">
    <div>Дата создания: <strong>{{ statementData.statement[0].date }}</strong></div>
    <div>Номер документа: <strong>{{ statementData.statement[0].nomdok }}</strong></div>
    <div>Предмет: <strong>{{ statementData.predmet.name }}</strong></div>

    <table width="100%"  class="table table-hover" name="table">
                    <thead>
                      <tr>
                        
                        <th scope="col">#</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Средний балл за модули</th>
                        <th v-if="searchVidKontr==1" scope="col">Баллы за зачет</th>
                        <th v-if="searchVidKontr==2" scope="col">Баллы за экзамен</th>
                        <th>Итоговая оценка</th>

                      </tr>
                    </thead>
                    
                    <tbody>
                      <tr @click="" v-for="(student,idx) in statementData.result">
                        <td scope="row">{{ idx+1 }}</td>
                        <td >{{ student.user[0].surname }} {{ student.user[0].name }} {{ student.user[0].patronomic }}</td>
                        <td ><div> {{student.srBall.toFixed(0)}} </div></td>
                        <td ><div v-if="printTable1"> {{student.dataStatement.ocenka_exam}} </div></td>
                        <td ><div v-if="printTable1">{{ student.dataStatement.ocenka }}</div></td>
                      </tr>
        
                    </tbody>
                  </table> 
                  </div>
                  <button id="printTable1" @click="printTable1=false" class="btn btn-outline-primary mr-5 mt-3">Печать пустой таблицы</button> 

                  <button id="printTable" @click="printTable1=true" class="btn btn-outline-primary mt-3">Печать готовой таблицы</button> 
 

  </div>
    <div v-show="stage==3">
      <div><button @click="stage=1" class="btn btn-outline-primary">Создать ведомость</button></div>

      <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="fakultet" >Выберите факультет</label>
      <div class="col-sm-5">
        <select v-model="searchFakultet" class="form-select" name="fakultet" aria-label="Default select example">
            <option v-for="fakultet in fakultets" :value="fakultet.id">{{ fakultet.name }}</option>
        </select>
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="kurs" >Выберите курс</label>
      <div class="col-sm-5">
        <select v-model="searchKurs" class="form-select" name="kurs">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>

        </select>
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="group" >Выберите группу</label>
      <div class="col-sm-5">
        <select v-model="searchGrop" class="form-select" name="group">
            <option v-for="group in groups" :value="group.id">{{ group.name }}</option>
        </select>
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="teacher" >Выберите преподавателя</label>
      <div class="col-sm-5">
        <select v-model="searchTeacher" class="form-select" name="teacher">
            <option v-for="teacher in teachers" :value="teacher.teacher.id">{{ teacher.user.surname }} {{ teacher.user.name }} {{ teacher.user.patronomic }} {{ teacher.user.email }}</option>
        </select>
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="predmet" >Выберите предмет</label>
      <div class="col-sm-5">
        <select v-model="searchPredmet" class="form-select" name="predmet">
            <option v-for="predmet in predmets" :value="predmet.id">{{ predmet.name }}</option>
        </select>
      </div>
    </div>

      <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="vidkontr" >Выберите вид контроля</label>
      <div class="col-sm-5">
        <select v-model="searchVidKontr" class="form-select" name="vidkontr">
            <option v-for="vidkontr in vidkontrols" :value="vidkontr.id">{{ vidkontr.name }}</option>
        </select>
      </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" @click="searchStatement" class="btn btn-outline-primary">Далее</button>
    </div>

    </div>

    <div v-show="stage==1">
      <div><button @click="stage=3" class="btn btn-outline-primary">Найти ведомость</button></div>

<h5 class="text-center mb-5">Создать ведомость</h5>
<div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="fakultet" >Выберите факультет</label>
      <div class="col-sm-5">
        <select v-model="selectFakultet" class="form-select" name="fakultet" aria-label="Default select example">
            <option v-for="fakultet in fakultets" :value="fakultet.id">{{ fakultet.name }}</option>
        </select>
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="kurs" >Выберите курс</label>
      <div class="col-sm-5">
        <select v-model="selectKurs" class="form-select" name="kurs">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>

        </select>
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="group" >Выберите группу</label>
      <div class="col-sm-5">
        <select v-model="selectGroup" class="form-select" name="group">
            <option v-for="group in groups" :value="group.id">{{ group.name }}</option>
        </select>
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="teacher" >Выберите преподавателя</label>
      <div class="col-sm-5">
        <select v-model="selectTeacher" class="form-select" name="teacher">
            <option v-for="teacher in teachers" :value="teacher.teacher.id">{{ teacher.user.surname }} {{ teacher.user.name }} {{ teacher.user.patronomic }} {{ teacher.user.email }}</option>
        </select>
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="predmet" >Выберите предмет</label>
      <div class="col-sm-5">
        <select v-model="selectPredmet" class="form-select" name="predmet">
            <option v-for="predmet in predmets" :value="predmet.id">{{ predmet.name }}</option>
        </select>
      </div>
    </div>

      <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="vidkontr" >Выберите вид контроля</label>
      <div class="col-sm-5">
        <select v-model="selectVidKontr" class="form-select" name="vidkontr">
            <option v-for="vidkontr in vidkontrols" :value="vidkontr.id">{{ vidkontr.name }}</option>
        </select>
      </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="button" @click="statmentsStudents" class="btn btn-outline-primary">Далее</button>
    </div>

</div>
<div v-if="stage==2">
    
    <table width="100%"  class="table table-hover" name="table" id="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Средний балл за модули</th>
                        <th v-if="selectVidKontr==1" scope="col">Баллы за зачет</th>
                        <th v-if="selectVidKontr==2" scope="col">Баллы за экзамен</th>

                        <th scope="col">Итоговая оценка</th>




                
                      </tr>
                    </thead>
                    <tbody>
                      <tr @click="" v-for="(student,idx) in students">
                        <td scope="row">{{ idx+1 }}</td>
                        <td >{{ student.user[0].surname }} {{ student.user[0].name }} {{ student.user[0].patronomic }}</td>
                        <td ><input readonly class="form-control mr-5 "  style="width:40%;" type="text" :class="String(student.student.id)" :value = "student.srBall.toFixed(0)"></td>
                        <td ><input  class="form-control mr-5 " max="40" :class="String(student.student.id)" style="width:40%;" type="number" ></td>
                        <td ><input readonly @keyup.tab="getResult(student.student.id)" class="form-control mr-5 " style="width:40%;" type="text" :class="String(student.student.id)"></td>

                      </tr>
        
                    </tbody>
                  </table>  
                  <div class="d-flex justify-content-end mt-5">
                    <button @click="save()" class="btn btn-outline-primary">Сохранить</button>
                  </div>

</div>
    
</template>

<script>

export default{
    props:['fakultets','vidkontrols'],
    data(){
        return{
          
            selectFakultet:null,
            groups:[],
            selectGroup:null,
            selectKurs:null,
            selectTeacher:null,
            teachers:[],
            selectPredmet:null,
            predmets:[],
            selectVidKontr:null,
            stage:1,
            students:[],
            searchFakultet:null,
            searchGrop:null,
            searchKurs:null,
            searchPredmet:null,
            searchTeacher:null,
            searchVidKontr:null,
            statementData:[],
            printTable1:true,

        }
    },
    methods:{
 

      searchStatement(){
        axios.post('/searchStatement',{
          fakultet:this.searchFakultet,
          group:this.searchGrop,
          predmet:this.searchPredmet,
          teacher:this.searchTeacher,
          vidkontr:this.searchVidKontr
        }).then(response=>{
          this.stage = 4;
          this.statementData = response.data;
          console.log(this.statementData);
        });
      },
        save(){
            axios.post('/saveStatments',{
                students:this.students,
                teacher:this.selectTeacher,
                predmet:this.selectPredmet,
                group:this.selectGroup,
                vidkontr:this.selectVidKontr
            }).then(response=>{
                alert(response.data.status);                
            });
        },
        statmentsStudents(){
            this.stage = 2;
            axios.post('/getStudentsforStatements',{idGroup:this.selectGroup,predmet:this.selectPredmet}).then(response=>{
                this.students = response.data.students;
            });
        },
        getResult(id){
            let inputs = document.getElementsByClassName(`${id}`);
            if(this.selectVidKontr==2){
            let sum = Number(inputs[0].value) + Number(inputs[1].value);
            inputs[2].value = sum > 86 ? '5' : sum > 71 && sum < 86 ? '4' : sum >= 60 && sum<71 ? '3' : '2';
            this.students.filter(el=>{
                if(el.student.id==id){
                    el.exam = inputs[1].value;
                    el.finally = inputs[2].value;
                }
            });
          } else {

  let sum = Number(inputs[0].value) + Number(inputs[1].value);
            inputs[2].value = sum >= 60 ? 'Зачет' : 'Незачет';
            this.students.filter(el=>{
                if(el.student.id==id){
                    el.exam = inputs[1].value;
                    el.finally = inputs[2].value;
                }
            });
          }
        }

    },
    mounted(){


      jQuery(function($) {
        const tableToPrint = document.getElementById("printMe");

        function printData(tableToPrint) {
            Popup($(tableToPrint).html());
        }

        function Popup(data) {
            const mywindow = window.open("", "printMe", "height=600, width=1000");
            // стили таблицы
            let tableToPrint1 = document.getElementById("printMe");

            mywindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">');
            mywindow.document.write(tableToPrint1.outerHTML);
            mywindow.document.close(); // для IE >= 10
            mywindow.focus(); // для IE >= 10
            mywindow.print();
            mywindow.close();
            return true;
        }

        $(document).on("click", "#printTable", function() {
            printData();
            return false;
        });
        $(document).on("click", "#printTable1", function() {
            printData();
            this.printTable1 = true;
            return false;
        });
    });

    },
    watch:{
        searchFakultet(newValue,oldValue){
          this.searchGrop = null;
            this.searchPredmet = null;
            this.searchTeacher = null;
            this.predmets = [];
            this.teachers = [];
            this.groups = [];
            this.searchKurs = 1;
            axios.post('/getTeachers',{fakultet:newValue}).then(response=>{
                this.teachers = response.data.teachers;
            });

        },
        selectFakultet(newValue,oldValue){
            this.selectGroup = null;
            this.selectPredmet = null;
            this.selectTeacher = null;
            this.predmets = [];
            this.teachers = [];
            this.groups = [];
            this.selectKurs = 1;
            axios.post('/getTeachers',{fakultet:newValue}).then(response=>{
                this.teachers = response.data.teachers;
            });
        },
        searchTeacher(newValue,oldValue){
          axios.post('/getPredmets',{teacher:newValue}).then(response=>{
                this.predmets = response.data.predmets;
            });
        },

        selectTeacher(newValue,oldValue){
            axios.post('/getPredmets',{teacher:newValue}).then(response=>{
                this.predmets = response.data.predmets;
            });
        },
        searchKurs(newValue,oldValue){
          axios.post('/getGroups',{idFakultet:this.searchFakultet,kurs:newValue}).then(response=>{
                this.groups = response.data.groups;
                this.searchGrop = this.groups[0] ? this.groups[0].id : '';
            });
        },
        selectKurs(newValue,oldValue){
            axios.post('/getGroups',{idFakultet:this.selectFakultet,kurs:newValue}).then(response=>{
                this.groups = response.data.groups;
                this.selectGroup = this.groups[0] ? this.groups[0].id : '';
            });
        }
    }
}
</script>

<style>
/*  */
</style>