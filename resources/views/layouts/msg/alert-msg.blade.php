@if(count($errors)>0)
    @foreach($errors->all() as $error)
    <div class="danger-alert" style="color:red;">
        {{$error}}
    </div>
    @endforeach
@endif