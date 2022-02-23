@if(count($errors)>0)
    @foreach($errors->all() as $error)
    <div class="danger-alert" style="color:red;">
        {{$error}}
    </div>
    @endforeach
@endif

@php
    if(Session::has('success')){
        toast(Session::get('success'), 'success')->timerProgressBar()->width('300px');
        Session::forget('success');
    }

    if(Session::has('error')){
        toast(session::get('error'),session::get('error_type'))->timerProgressBar()->autoClose(7000);
        Session::forget('error');
        Session::forget('error_type');
    }
@endphp