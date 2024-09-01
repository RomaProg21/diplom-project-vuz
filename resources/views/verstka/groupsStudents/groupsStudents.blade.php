@include('verstka.includes.header')
@include('verstka.includes.navbar')


<div class="main-panel" id="app">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">
                <h5 class="text-center">Добавить новую группу</h5>
                <form method="POST" action="{{ route('createGroup') }}" style="margin:20px;padding:20px;border:1px solid teal; border-radius:15px">
                   @csrf
                   @method('post')

                    <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="name_group" >Название группы</label>
                    <div class="col-sm-5">
                        <input type="text"  name="name_group" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="fakultet_id" >Факультет</label>
                    <div class="col-sm-5">
                        <select name="fakultet_id" class="form-select" id="">
                            @foreach($fakultets as $fakultet)
                            <option value="{{$fakultet->id}}">{{$fakultet->name}}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="kurs" >Курс</label>
                    <div class="col-sm-5">
                        <input type="text" name="kurs" class="form-control">
                    </div>
                  
                  </div>

                  <div class="d-flex justify-content-end">
                  <button class="btn btn-outline-primary" style="border-radius: 10px" type="submit">Сохранить</button>
                </div>
                </form>

                <table class="table table-hover" id="example">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название группы</th>
                        <th scope="col">Факультет</th>
                        <th scope="col">Курс</th>


                
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($result as $res)
                      <tr>
                        <th scope="row">{{$res['group']->id}}</th>
                        <td>{{$res['group']->name}}</td>
                        <td>{{$res['fakultet']->name}}</td> 
                        <td>{{$res['group']->kurs}}</td>
  
                      </tr>
                      @endforeach
        
                    </tbody>
                  </table>
                  
                
              </div>
             </div>

             </div>
        </div>

</div>

    </div>
</div>

@include('verstka.includes.script')

<script>
var table = new DataTable('#example', {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/ru.json',
    },
});
</script>