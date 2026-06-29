@extends('themes.default1.installer.layout.installer')

@section('license')
done
@stop

@section('environment')
done
@stop

@section('database')
active
@stop

@section('content') 

<h1 style="text-align: center;">Configuración de la Base de Datos</h1>
Esta prueba verificará los requisitos previos necesarios para instalar PlataformaEscolar.<br/>
<?php
/**
 * PlataformaEscolar HELPDESK Prueba
 *
 */
// -- Por favor, proporcione parámetros de conexión a la base de datos válidos. ------------------------------
$default = Session::get('default');
$host = Session::get('host');
$username = Session::get('username');
$password = Session::get('password');
$databasename = Session::get('databasename');
$dummy_install = Session::get('dummy_data_installation');
$port = Session::get('port');
define('DB_HOST', $host); // Dirección de su servidor MySQL (generalmente localhost)
define('DB_USER', $username); // Nombre de usuario que se utiliza para conectarse al servidor
define('DB_PASS', $password); // Contraseña del usuario
define('DB_NAME', $databasename); // Nombre de la base de datos a la que se está conectando
define('DB_PORT', $port); // Puerto de la base de datos a la que se está conectando
define('PROBE_VERSION', '4.2');
define('PROBE_FOR', '<b>PlataformaEscolar</b> HELPDESK 1.0');
define('STATUS_OK', 'Ok');
define('STATUS_WARNING', 'Warning');
define('STATUS_ERROR', 'Error');

class TestResult {

    var $message;
    var $status;

    function __construct($message, $status = STATUS_OK) {
        $this->message = $message;
        $this->status = $status;
    }

}

// TestResult
if (DB_HOST && DB_USER && DB_NAME) {
    ?>
    <?php
    $mysqli_ok = true;
    $results = [];
    // error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    error_reporting(0);
try {
    if ($default == 'mysql') {
        if(DB_PORT != '' && is_numeric(DB_PORT)) {
            $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        } else {
            $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        }
        if ($connection) {
            $results[] = new TestResult('Conectado a la base de datos como ' . DB_USER . '@' . DB_HOST . DB_PORT, STATUS_OK);
            if (mysqli_select_db($connection, DB_NAME)) {
                $results[] = new TestResult('Database "' . DB_NAME . '" seleccionada', STATUS_OK);
                $mysqli_version = mysqli_get_server_info($connection);
                if (version_compare($mysqli_version, '8') >= 0) {
                    $results[] = new TestResult('Versión de MySQL: ' . $mysqli_version, STATUS_OK);
                    // $have_inno = check_have_inno($connection);
                    $sql = "SHOW TABLES FROM " . DB_NAME;
                    $res = mysqli_query($connection, $sql);
                    if (mysqli_fetch_array($res) === null) {
                        $results[] = new TestResult('La base de datos está vacía, puede continuar con la instalación.', STATUS_OK);
                        $mysqli_ok = true;
                    } else {
                        $results[] = new TestResult('PlataformaEscolar HELPDESK requiere una base de datos vacía, su base de datos ya tiene tablas y datos en ella.', STATUS_ERROR);
                        $mysqli_ok = false;
                    }
                } else {
                    $results[] = new TestResult('Tu versión de MySQL es ' . $mysqli_version . '. Recomendamos actualizar a al menos MySQL 8!', STATUS_ERROR);
                    $mysqli_ok = false;
                } // if
            } else {
                $results[] = new TestResult('Fallo al seleccionar la base de datos. ' . mysqli_connect_error(), STATUS_ERROR);
                $mysqli_ok = false;
            } // if
        } else {
            $results[] = new TestResult('Fallo al conectar a la base de datos. ' . mysqli_connect_error(), STATUS_ERROR);
            $mysqli_ok = false;
        } // if
    }
}catch (\Exception $exception) {
    $results[] = new TestResult('Fallo al conectar a la base de datos. ' . $exception->getMessage(), STATUS_ERROR);
    $mysqli_ok = false;
}

    // elseif($default == 'pgsql') {
    //     if ($connection2 = pg_connect("'host='.DB_HOST.' port='.DB_PORT.' dbname='.DB_NAME.' user='.DB_USER.' password='.DB_PASS.")) {
    //         $results[] = new TestResult('Connected to database as ' . DB_USER . '@' . DB_HOST, STATUS_OK);
    //     } else {
    //         $results[] = new TestResult('Failed to connect to database. <br> PgSQL said: ' . mysqli_error(), STATUS_ERROR);
    //         $mysqli_ok = false;
    //     }
    // } elseif($default == 'sqlsrv') {
    // }
    // ---------------------------------------------------
    //  Validators
    // ---------------------------------------------------
// dd($results);
    ?><p class="setup-actions step"><?php
    foreach ($results as $result) {
        print '<br><span class="' . strtolower($result->status) . '">' . $result->status . '</span> &mdash; ' . $result->message . '';
    } // foreach
    ?> </p>
    <!-- </ul> -->
<?php } else { ?>
    <br/>
    <ul>
        <li><p>No se ha podido probar la conexión a la base de datos. Por favor, asegúrese de que el servidor de la base de datos esté en funcionamiento y de que PHP esté gestionando las sesiones correctamente.</p></li>
    </ul>
    <p>Por favor, <a href="{{ URL::route('configuration') }}">haga clic aquí</a> para continuar el proceso de instalación.</p>
    <?php $mysqli_ok = null; ?>
<?php } ?>

<?php if ($mysqli_ok !== null) { ?>
    <?php if ($mysqli_ok) { ?>

        <div class="woocommerce-message woocommerce-tracker" >
            <p id="pass">Conexión a la base de datos exitosa. Este sistema puede ejecutar PlataformaEscolar</p>
        </div>

        <script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}"></script>

        <span id="wait"></span>

        {!! Form::open( ['id'=>'form','method' => 'POST'] )!!}
        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
        <!-- <b>default</b><br> -->
        <input type="hidden" name="default" value="{!! $default !!}"/>
        <!-- <b>Host</b><br> -->
        <input type="hidden"  name="host" value="{!! $host !!}"/>
        <!-- <b>Database Name</b><br> -->
        <input type="hidden" name="databasename" value="{!! $databasename !!}"/>
        <!-- <b>User Name</b><br> -->
        <input type="hidden" name="username" value="{!! $username !!}"/>
        <!-- <b>User Password</b><br> -->
        <input type="hidden" name="password" value="{!! $password !!}"/>
        <!-- <b>Port</b><br> -->
        <input type="hidden" name="port" value="{!! $port !!}"/>
        <!-- Dummy data installation -->
        <input type="hidden" name="dummy_install" value="{!! $dummy_install !!}"/>

        <input type="submit" style="display:none;">

        </form>

        <div id="show" style="display:none;">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-9" style="text-align: center"id='loader' >
                    <img src="{{asset("lb-faveo/media/images/gifloader.gif")}}"><br/><br/><br/>
                </div>
            </div>
        </div>

        <div style="border-bottom: 1px solid #eee;">
            <p class="setup-actions step" id="retry">
                <a href="{{ URL::route('account') }}" class="pull-right" id="next" style="text-color:black"><input type="submit" id="submitme" class="button-primary button button-large button-next" value="Continuar"> </a>
                <a href="{{ URL::route('configuration') }}" class="button button-large button-next" style="float: left">Anterior</a>
            </p>
        </div>

        <br/>

        <script type="text/javascript">
        // submit a ticket
        $(document).ready(function () {
            $("#form").submit();
        });
        // Edit a ticket
        $('#form').on('submit', function () {
            $.ajax({
                type: "GET",
                url: "{!! url('create/env') !!}",
                dataType: "json",
                data: $(this).serialize(),
                beforeSend: function () {
                    $("#conn").hide();
                    $("#show").show();
                    $("#wait").show();
                },
                success: function (response) {
                    var data=response.result;
                    console.log(data);
                    var message = data.success;
                    var next = data.next;
                    var api = data.api;
                    $('#submitme').attr('disabled','disabled');
                    $('#wait').append('<ul><li>'+message+'</li><li class="seco">'+next+'...</li></ul>');
                    callApi(api);
                },
                error: function(response){
                    var data=response.responseJSON.result;
                    $('#wait').append('<ul><li style="color:red">'+data.error+'</li></ul>');
                    $('#loader').hide();
                    $('#next').find('#submitme').hide();
                    $('#retry').append('<input type="button" id="submitm" class="button-primary button button-large button-next" value="Reintentar" onclick="reload()">');
                    
                }
            })
            return false;
        });

        function callApi(api) {
            $.ajax({
                type: "GET",
                url: api,
                dataType: "json",
                data: $(this).serialize(),
                success: function (response) {
                    var data=response.result;
                    console.log(data);
                    var message = data.success;
                    var next = data.next;
                    var api = data.api;
                    $("#wait").find('.seco').remove();
                    $('#wait ul').append('<li>'+message+'</li><li class="seco">'+next+'...</li>');
                    if (message == 'Database has been setup successfully.') {
                        $('#loader').hide();
                        $('#next').find('#submitme').show();
                        $('#submitme').removeAttr('disabled');
                        $('.seco').hide();
                    } else {
                        callApi(api);
                    }
                },
                error: function(response){
                    console.log(response);
                    var data=response.responseJSON.result;
                    $('#seco').append('<p style="color:red">'+data.error+'</p>');
                    $('#loader').hide();
                    $('#next').find('#submitme').hide();
                    $('#retry').append('<input type="button" id="submitm" class="button-primary button button-large button-next" value="Reintentar" onclick="reload()">');
                }
            });
        }
        function reload(){
            $('#retry').find('#submitm').remove();
            $('#loader').show();
            $('#wait').find('ol').remove();
            $.ajax({
                type: "GET",
                url: "{!! url('create/env') !!}",
                dataType: "json",
                data: $(this).serialize(),
                beforeSend: function () {
                    $("#conn").hide();
                    $("#show").show();
                    $("#wait").show();
                },
                success: function (response) {
                    var data=response.result;
                    console.log(data);
                    var message = data.success;
                    var next = data.next;
                    var api = data.api;
                    $('#submitme').attr('disabled','disabled');
                    $('#wait').append('<ul><li>'+message+'</li><li class="seco">'+next+'...</li></ul>');
                    callApi(api);
                },
                error: function(response){
                    var data=response.responseJSON.result;
                    $('#wait').append('<ul><li style="color:red">'+data.error+'</li></ul>');
                    $('#loader').hide();
                    $('#next').find('#submitme').hide();
                    $('#retry').append('<input type="button" id="submitm" class="button-primary button button-large button-next" value="Reintentar" onclick="reload()">');
                    
                }
            })
            
        }
        </script>

    <?php } else { ?>
        <div class="woocommerce-message woocommerce-tracker" >
            <p id="fail">La conexión a la base de datos ha fallado. Este sistema no cumple con los requisitos del sistema PlataformaEscolar.</p>
        </div>
        <p>Esto significa que la información de nombre de usuario y contraseña es incorrecta o podemos&rsquo;...no se puede conectar con el servidor de la base de datos. Esto podría significar que su proveedor de alojamiento...&rsquo;El servidor de bases de datos está caído.</p>
        <ul>
            <li>¿Está seguro de que tiene el nombre de usuario y la contraseña correctos?</li>
            <li>¿Está seguro de haber escrito el nombre de host correcto?</li>
            <li>¿Está seguro de que el servidor de base de datos está en funcionamiento?</li>
        </ul>
        <p>Si no está seguro de lo que significan estos términos, probablemente deba contactar con su proveedor de alojamiento. Si aún necesita ayuda, puede visitar siempre el <a href="http://www.plataformaescolar.org">Soporte de PlataformaEscolar </a>.</p>


        <div  style="border-bottom: 1px solid #eee;">
            @if(Cache::has('step4')) <?php Cache::forget('step4') ?> @endif
            <p class="setup-actions step">
                <input type="button" id="submitme" class="button-danger button button-large button-next" style="background-color: #d43f3a;color:#fff;" value="Continuar" disabled>
                <a href="{{URL::route('configuration')}}" class="button button-large button-next" style="float: left;">Anterior</a>
            </p>
        </div>
        <br/><br/>
    <?php } // if  ?>
    <div id="legend">
        {{-- <ul> --}}
        <p class="setup-actions step">
          @include('themes.default1.installer.components.info-procces-install')
        </p>
        {{-- </ul> --}}
    </div>
<?php } // if  ?>

@stop