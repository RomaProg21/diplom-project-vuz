@include('verstka.includes.header')
@include('verstka.includes.navbar')
@vite('resources/js/info.js')
<div class="main-panel" id="app">        
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
             <div class="card">
              <div class="card-body">
                    <info-app
                    :user = "{{ json_encode($user) }}"
                    >
                <div>{{$qrcode}}</div>
                </info-app>
            </div>
        </div>
    </div>
</div>
</div>
</div>



@include('verstka.includes.script')
