@if(Session::has('companyname'))
    {{ strtoupper(Session::get('companyname')) }}
@else
    @php( $companyname = \App\Models\Settings::find(1) )
    {{ Session::put('companyname', $companyname->value) }} 
    {{ strtoupper($companyname->value) }} 
@endif