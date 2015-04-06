@if (Session::has('alert'))
  <div class='alert btn-danger'>{!! Session::get('alert') !!}</div>
@endif