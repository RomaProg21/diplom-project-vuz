<template>
    <div class="row">
      <div class="col-lg-12 grid-margin">
       <div class="card">
        <div class="card-body">
<!--   
      <div class="form-group row">  
      <label class="col-sm-3 col-form-label" for="role_user" >Выберите роль пользователя<span style="color:red"> *</span></label>
        <div class="col-sm-5">
          <select required v-model="SelectRole" class="form-select" name="role_user" aria-label="Default select example">
    <option  value="1">Админ(Сотрудник деканата)</option>
    <option selected value="2">Студент</option>
    <option value="3">Преподаватель</option>
          </select>
        </div>
      </div> -->

      <div class="form-group row" v-show="phase==1">  

        <div class="table-responsive">
<table  class="table table-hover" width="100%" id="fakultets">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Факультет</th>

                
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="cursor:pointer" @click="GetGroups(fakultet.id)" v-for="(fakultet,idx) in fakultets">
                        <th scope="row">{{ idx+1 }}</th>
                        <th >{{ fakultet.name}}</th>
                      </tr>
        
                    </tbody>
                  </table>
                </div>


            <!-- <ul class="list-group">
  <li v-for="fakultet in fakultets" class="list-group-item list-group-item-action" @click="GetGroups(fakultet.id)" aria-current="true">{{ fakultet.name }}</li>
            </ul> -->

      </div>

      <div class="form-group row" v-if="phase==2">  
           <div class="d-flex justify-content-end">
      <button class="btn btn-outline-primary" @click="phase=1" type="button">Назад</button>
      </div> 
      <label class="col-sm-3 col-form-label" for="surname" >Выберите группу</label>
        <div class="col-sm-5">
       <input type="text" name="" class="form-control mb-3"  placeholder="Поиск" v-model="searchGroup">
            <ul class="list-group">
  <li v-for="group in filteredData()" class="list-group-item list-group-item-action" @click="GetStudents(group.id)" aria-current="true">{{ group.name }}</li>
            </ul>

        </div>
      </div>


      
      <div class="form-group row" v-if="phase==3">  
           <div class="d-flex justify-content-end">
      <button class="btn btn-outline-primary" @click="phase=2" type="button">Назад</button>
      </div> 
      <label class="col-sm-3 col-form-label" for="surname" >Выберите студента</label>
        <div class="col-sm-5">
          <input type="text" name="" class="form-control mb-3"  placeholder="Поиск" v-model="searchStudent">

            <ul class="list-group">
  <li v-for="student in fitlerStudent()" class="list-group-item list-group-item-action" @click="GetInfoStudent(student.user[0])" aria-current="true">{{ student.user[0].surname }} {{ student.user[0].name }} {{ student.user[0].patronomic }}</li>
            </ul>

        </div>
      </div>
    
    <div v-show="phase==4">

        <div class="d-flex justify-content-end">
      <button class="btn btn-outline-primary" @click="phase=3" type="button">Назад</button>
      </div> 

      <div class="form-group row" >  
         
      <label class="col-sm-3 col-form-label" for="surname" >Фамилия</label>
        <div class="col-sm-5">
            <input type="text" name="surname" class="form-control" v-model="surname">
        </div>
      </div>

      <div class="form-group row" >  
         
         <label class="col-sm-3 col-form-label" for="name" >Имя</label>
           <div class="col-sm-5">
               <input type="text" name="name" class="form-control" v-model="name">
           </div>
         </div>

         <div class="form-group row" >  
         
         <label class="col-sm-3 col-form-label" for="patrnomic" >Отчество</label>
           <div class="col-sm-5">
               <input type="text" name="patrnomic" class="form-control" v-model="patronomic">
           </div>
         </div>

         <div class="form-group row" >  
         
         <label class="col-sm-3 col-form-label" for="password" >Пароль</label>
           <div class="col-sm-5">
               <input type="text" name="password" class="form-control" v-model="password">
           </div>
         </div>

         <div class="form-group row" >  
         
         <label class="col-sm-3 col-form-label" for="pasport" >Паспорт</label>
           <div class="col-sm-5">
               <input type="text" name="pasport" class="form-control" v-model="pasport">
           </div>
         </div>

         <div class="form-group row" >  
         
         <label class="col-sm-3 col-form-label" for="email" >Email</label>
           <div class="col-sm-5">
               <input type="text" name="email" class="form-control" v-model="email">
           </div>
         </div>


         <div class="form-group row" >  
         
         <label class="col-sm-3 col-form-label" for="group_student" >Группа студента</label>
           <div class="col-sm-5">
            <select class="form-select" name="group_student" v-model="studentGroup">
            <option v-for="all in allGroup" data="" type="" :value="all.id">{{ all.name }}</option>
            </select>
           </div>
         </div>

         <div class="d-flex justify-content-end">
      <button class="btn btn-outline-primary" type="submit">Сохранить</button>
      </div> 

    </div>

     
      
      
  </div>
  </div>
  
  
  </div>
  
  
  </div>
  
  </template>
  
  <script>

  export default{
   
    props:['fakultets'],
      data(){
          return{
            phase:1,
            groups:[],
            groups1:null,
            students:[],
            idFakultetGroup:null, //факультет выбранной группы
            studentGroup:null, //группа студента
            name:null, //имя студента
            email:null, //email студента
            surname:null, //фамилия студента
            patronomic:null, //отчество студента
            password:null, //пароль студента
            pasport:null, //паспорт студента
            allGroup:null, //все группы
            searchGroup:'',
            searchStudent:'',
          }
      },  
      methods:{
        GetGroups(idFakultet){
            axios.post('/getGroups',{idFakultet:idFakultet}).then(response=>{
                this.phase = 2;
                this.idFakultetGroup = idFakultet;
                this.groups = response.data.groups;
                this.groups1 =  response.data.groups;

            });
            
        },
        GetStudents(idGroup){
            axios.post('/getStudents',{idGroup:idGroup}).then(response=>{
                this.phase = 3;
                this.students = response.data.students;
                this.studentGroup = response.data.group;
             //console.log(this.students);
            });
        },
        GetInfoStudent(student){
            axios.post('/allGroup').then(response=>{
                this.allGroup = response.data.allGroup;
            });
            this.phase = 4;
            this.email = student.email;
            this.name = student.name;
            this.surname = student.surname;
            this.patronomic = student.patronomic;
            this.password = student.password;
            this.pasport = student.pasport;
        
        },
        filteredData() {
          if(this.groups.length>0){
          return this.groups.filter(row => {
            return Object.values(row).some(value => {
              return String(value).toLowerCase().includes(this.searchGroup.toLowerCase());
            });
          });
        }
        },
        fitlerStudent() {
          if(this.students.length>0){
          return this.students.filter(row => {
            return Object.values(row.user[0]).some(value => {
              return String(value).toLowerCase().includes(this.searchStudent.toLowerCase());
            });
          });
        }
        },
   
      },
      watch:{
      //   searchGroup(newValue,oldValue){  
      //      this.groups.filter((item) =>
      //      newValue
      //     .toLowerCase()
      //     .split(' ')
      //     .every((v) => item.name.toLowerCase().includes(v))
      // );       
      //     // let n = this.groups.filter(el=>{
           
      //     //   el.name.toLowerCase() == newValue.toLowerCase();
      //     // });
      //     // console.log(n);
      //     if(newValue.length==0){
      //       this.groups = this.groups1;
      //     }
      //   }
      },
      mounted(){
        
        new DataTable('#fakultets', {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/ru.json',
    },
});
        
      },
      computed:{
       
      },
  }
  </script>