@include('verstka.includes.header')
@include('verstka.includes.navbar')

@vite('resources/js/app.js')
<div class="main-panel" id="app">        
    <div class="content-wrapper">
    <form action="{{ route('createFunctionalAbonent') }}" method="POST">
        @csrf
        @method('post')
    <create-abonent
    :groups = "{{$groups}}"
    :fakultets = "{{$fakultets}}"
    ></create-abonent>
    </form>
    </div>
    </div>
</div>

@include('verstka.includes.script')