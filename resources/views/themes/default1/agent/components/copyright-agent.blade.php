<?php 
    $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first(); 
?>
@if ($company->company_name)
    <div class="float-right d-none d-sm-block">
        <span style="font-weight: 500">{!! Lang::get('lang.version') !!}</span> {!! Config::get('app.version') !!}
    </div>
    <span style="font-weight: 500">{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}" target="_blank">{!! $company->company_name !!}</a>.</span> {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="http://www.plataformaescolar.org/" target="_blank">PlataformaEscolar</a>
@else
   <div class="float-right d-none d-sm-block">                     
        <span style="font-weight: 500">{!! Lang::get('lang.version') !!}</span> {!! Config::get('app.version') !!}
    </div>
    <span style="font-weight: 500">{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="#" target="_blank">""</a>.</span> {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="http://www.plataformaescolar.org/" target="_blank">PlataformaEscolar</a>
@endif