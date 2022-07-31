@php
    if(Session::has('success')){
        toast(Session::get('success'), 'success')->timerProgressBar();
        Session::forget('success');
    }

    if(Session::has('error')){
        toast(session::get('error'),session::get('error_type'))->timerProgressBar()->autoClose(7000);
        Session::forget('error');
        Session::forget('error_type');
    }

    if(Session::has('errors')){
        // foreach($errors->all() as $error){
            // toast($errors->all(),'warning')->timerProgressBar()->autoClose(7000);
            // alert()->warning('Validation Error',$errors->all())->timerProgressBar()->autoClose(7000);
        // }
            Session::forget('errors');
    }
@endphp
