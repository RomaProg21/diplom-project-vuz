<template>
  <div class="row">
    <div class="col-lg-12 grid-margin">
     <div class="card">
      <div class="card-body">

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="role_user" >Выберите роль пользователя<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <select required v-model="SelectRole" class="form-select" name="role_user" aria-label="Default select example">
  <option  value="1">Админ(Сотрудник деканата)</option>
  <option selected value="2">Студент</option>
  <option value="3">Преподаватель</option>
        </select>
      </div>
    </div>

    <div class="form-group row" >  
    <label class="col-sm-3 col-form-label" for="fakultet_prepod" >Выберите факультет<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <select  class="form-select" name="fakultet_prepod" v-model="selectFakultet">
            <option v-for="fakultet in fakultets" :value="fakultet.id">{{ fakultet.name }}</option>
        </select>
      </div>
    </div>

    <div class="form-group row" v-if="SelectRole==2">  
    <label class="col-sm-3 col-form-label" for="fakultet_prepod" >Выберите курс<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <select  class="form-select" name="fakultet_prepod" v-model="selectKurs">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>

        </select>
      </div>
    </div>

    <div class="form-group row" v-if="SelectRole==2">  
    <label class="col-sm-3 col-form-label" for="groups_students" >Выберите группу студента<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <select required  class="form-select" name="groups_students" aria-label="Default select example">
            <option v-for="group in groups" :value="group.id">{{ group.name }}</option>
        </select>
      </div>
    </div>

 

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="surname" >Фамилия<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <input required type="text" class="form-control" name="surname" placeholder="Введите фамилию">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="name_user" >Имя<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <input required type="text" class="form-control" name="name_user" placeholder="Введите имя">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="patronomic" >Отчество<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <input required type="text" class="form-control" name="patronomic" placeholder="Введите отчество">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="pasport" >Паспорт<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <input required type="text" class="form-control" name="pasport" placeholder="Введите паспорт">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="password" >Пароль<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <input required type="text" class="form-control" name="password" placeholder="Введите пароль">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="email" >Email<span style="color:red"> *</span></label>
      <div class="col-sm-5">
        <input required type="text" class="form-control" name="email" placeholder="Введите email">
      </div>
    </div>

    <div class="d-flex justify-content-end">
    <button class="btn btn-outline-primary" type="submit">Создать</button>
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
            SelectRole:'2',
            selectFakultet:null,
            selectKurs:1,
            groups:[],


        }
    },  
    methods:{

    },
    watch:{
      selectFakultet(newValue,oldValue){
       this.selectKurs = 1;
       this.groups = [];
      },
      selectKurs(newValue,oldValue){
        axios.post('/getGroups',{
          idFakultet:this.selectFakultet,
          kurs:newValue,
        }).then(response=>{
          this.groups = response.data.groups;
        });
      },
    },
    mounted(){
    }
}
</script>