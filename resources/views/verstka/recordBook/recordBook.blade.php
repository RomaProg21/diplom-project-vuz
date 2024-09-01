@include('verstka.includes.header')
@include('verstka.includes.navbar')
@vite('resources/js/recordBook.js')
<div class="main-panel" id="app">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">

                <record-book
                :statement = "{{ json_encode($statement) }}"
                ></record-book>
             

            </div>
        </div>

        </div>
   </div>

</div>

</div>
</div>

@include('verstka.includes.script')
