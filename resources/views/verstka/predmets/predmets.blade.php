@include('verstka.includes.header')
@include('verstka.includes.navbar')


<div class="main-panel">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">
                <h5 class="text-center">Добавить новый предмет</h5>
                <form method="POST" action="{{ route('createPredmet') }}" style="margin:20px;padding:20px;border:1px solid teal; border-radius:15px">
                   @csrf
                   @method('post')

                    <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="name_predmet" >Название предмета</label>
                    <div class="col-sm-5">
                        <input type="text"  name="name_predmet" class="form-control">
                    </div>
                  </div>
                  <div id="app">
                  <predmets
                  :prepod-array-all = "{{ json_encode($prepodArrayAll) }}"
                  ></predmets>
                </div>

                  <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="clock" >Часы</label>
                    <div class="col-sm-5">
                        <input type="number"  name="clock" class="form-control">
                    </div>

                  </div>

                  <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="module" >Количество модулей</label>
                    <div class="col-sm-5">
                        <select name="module" class="form-select" id="module">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>

                        </select>
                    </div>
                  </div>

                  <div class="d-flex justify-content-end">
                  <button class="btn btn-outline-primary" style="border-radius: 10px" type="submit">Сохранить</button>
                </div>
                </form>
                <div class="table-responsive">
                <table class="table table-hover" id="example">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название предмета</th>
                        <th scope="col">Часы</th>
                        <th scope="col">ФИО</th>


                
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($result as $key =>$res)
                      <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$res['predmet']->name}}</td>
                        <td>{{$res['predmet']->clock}}</td>
                        <td>{{$res['user']->surname}} {{$res['user']->name}} {{$res['user']->patronomic}}</td> 
                        
  
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
</div>

@include('verstka.includes.script')

<script>
var table = new DataTable('#example', {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/ru.json',
    },
});
</script>
@vite('resources/js/predmets.js')
