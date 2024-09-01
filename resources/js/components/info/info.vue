<template>
 <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="date" >Фамилия</label>
      <div class="col-sm-3">
        <input readonly type="text" class="form-control" :value="user[0].surname">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="date" >Имя</label>
      <div class="col-sm-3">
        <input readonly type="text" class="form-control" :value="user[0].name">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="date" >Фамилия</label>
      <div class="col-sm-3">
        <input readonly type="text" class="form-control" :value="user[0].patronomic">
      </div>
    </div>

    <div class="form-group row">  
    <label class="col-sm-3 col-form-label" for="date" >email</label>
      <div class="col-sm-3">
        <input readonly type="text" class="form-control" :value="user[0].email">
      </div>
      <div>
        <button class="btn btn-outline-primary" @click="showQr=!showQr">QR-код для входа в ВУЗ</button>
      </div>
    </div>
<div v-show="showQr">
<slot></slot>
</div>

</template>

<script>
export default{ 
    props:['user'],
    data(){
        return{
            showQr:false
        }
    },
    methods:{

    },
    mounted(){

    }
}
</script>