@include('verstka.includes.header')
@include('verstka.includes.navbar')


<div class="main-panel" id="app">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">
                <h5 class="text-center">Добавить новый факультет</h5>
                <form method="POST" action="{{ route('createFakultet') }}" style="margin:20px;padding:20px;border:1px solid teal; border-radius:15px">
                   @csrf
                   @method('post')

                    <div class="form-group row" >  
                    <label class="col-sm-3 col-form-label text-center" for="fakultet_name" >Название факультета</label>
                    <div class="col-sm-5">
                        <input type="text"  name="fakultet_name" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-outline-primary" style="border-radius: 10px" type="submit">Сохранить</button>
                    </div>
                  </div>
                  
                </form>
                <div class="table-responsive">
                <table class="table table-hover" id="fakultets">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($fakultets as $fakultet)
                      <tr>
                        <th scope="row">{{$fakultet->id}}</th>
                        <td>{{$fakultet->name}}</td>
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
  var table = new DataTable('#fakultets', {
      language: {
          url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/ru.json',
      },
  });
  </script>