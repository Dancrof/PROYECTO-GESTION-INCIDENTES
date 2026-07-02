<?php 
    $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first(); 
?>
@if ($company->company_name)
    <div class="site-info col-md-6">
        <p class="text-muted">{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="{!! $company->website !!}" target="_blank">{!! $company->company_name !!}</a>. {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="https://www.plataformaescolar.org/"  target="_blank">PlataformaEscolar</a></p>
    </div>
@else
    <div class="site-info col-md-6">
        <p class="text-muted">{!! Lang::get('lang.copyright') !!} &copy; {!! date('Y') !!}  <a href="#" target="_blank">""</a>. {!! Lang::get('lang.all_rights_reserved') !!}. {!! Lang::get('lang.powered_by') !!} <a href="https://www.plataformaescolar.org/"  target="_blank">PlataformaEscolar</a></p>
    </div>
@endif