@include('verstka.includes.header')
@include('verstka.includes.navbar')
@vite('resources/js/sheduleExam.js')
<div class="main-panel" id="app">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">
                <form action="{{ route('createSheduleExam') }}" method="POST">
                    @csrf
                    @method('post')
                <shedule-exam
                :groupall ="{{  json_encode($groupAll) }}"
                :allpredmet ="{{  json_encode($allPredmet) }}"
                :result ="{{  json_encode($result) }}"
                :role = "{{Auth::user()->role_id}}"
                >
            </shedule-exam>
                </form>


            </div>
        </div>

        </div>
   </div>

</div>

</div>
</div>

@include('verstka.includes.script')
