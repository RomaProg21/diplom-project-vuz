@include('verstka.includes.header')
@include('verstka.includes.navbar')

@vite('resources/js/online.js')

<div class="main-panel">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">
                @if(Auth::user()->role_id!=2)
                <h5 class="text-center">Добавить новое онлайн занятие</h5>
                <form method="POST" action="{{ route('createNewOnline') }}" style="margin:20px;padding:20px;border:1px solid teal; border-radius:15px">
                   @csrf
                   @method('post')

          <div id="app">
            <online
            :all-predmets = "{{ json_encode($allPredmets) }}"
            :groups = "{{ json_encode($groups) }}"
            ></online>
          </div>

                  <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="link" >Ссылка</label>
                    <div class="col-sm-5">
                        <input type="text" name="link" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="date_start" >Дата начала</label>
                    <div class="col-sm-5">
                        <input type="datetime-local"  name="date_start" class="form-control">
                    </div>
                  </div>


                  <div class="d-flex justify-content-end">
                    <button class="btn btn-outline-primary" style="border-radius: 10px" type="submit">Сохранить</button>
                  </div>

                </form>
                @endif

                <div class="table-responsive">
                <table  class="table table-hover" id="example">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название предмета</th>
                        <th scope="col">Название группы</th>
                        <th scope="col">Ссылка</th>
                        <th scope="col">Дата</th>



                
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($onlines as $key=>$online)
                      <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$online['predmet']->name}}</td>
                        <td>{{$online['group']->name}}</td> 
                        <td >
                            {{$online['online']->link}}</td>
                        <td>{{$online['online']->date}}</td>

  
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
