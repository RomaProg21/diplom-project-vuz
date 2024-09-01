@include('verstka.includes.header')
@include('verstka.includes.navbar')

@vite('resources/js/students.js')
<div class="main-panel" id="app">        
    <div class="content-wrapper">
        <form action="{{ route('updateDataStudent') }}" method="POST">
            @csrf
            @method('post')
            <app-students
            :fakultets = "{{$fakultets}}"
            ></app-students>
        </form>
      
    </div>
    </div>
</div>

@include('verstka.includes.script')