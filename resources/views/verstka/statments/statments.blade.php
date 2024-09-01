@include('verstka.includes.header')
@include('verstka.includes.navbar')
<script 
    src="https://code.jquery.com/jquery-3.4.1.min.js" 
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" 
    crossorigin="anonymous">
</script>
@vite('resources/js/statments.js')
<div class="main-panel" id="app">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">

                <statments
                :fakultets="{{$fakultets}}"
                :vidkontrols = "{{$vidkontrolya}}"
                ></statments>

              </div>
            </div>
    
            </div>
       </div>
    
    </div>
    
    </div>
    </div>

@include('verstka.includes.script')


