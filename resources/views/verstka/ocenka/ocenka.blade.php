@include('verstka.includes.header')
@include('verstka.includes.navbar')
<div class="main-panel" id="app">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">
                
                <app-ocenka
                :result = "{{  json_encode($result) }}"
                :predmets = "{{json_encode($predmets)}}"
                :role = "{{Auth::user()->role_id}}"

                >
            </app-ocenka>
                  
                
              </div>
             </div>

             </div>
        </div>

</div>

    </div>
</div>


@include('verstka.includes.script')

<script>
   
    </script>
    @vite('resources/js/ocenka.js')
