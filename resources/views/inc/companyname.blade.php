@if(Session::has('companyname'))
    {{ Session::get('companyname') }}
@else
    @php( $companyname = \App\Models\Settings::find(1) )
    {{ Session::put('companyname', $companyname->value) }} 
    {{ $companyname->value }} 
@endif