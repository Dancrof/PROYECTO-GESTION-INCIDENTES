@extends('themes.default1.installer.layout.installer')

@section('environment')
active
@stop



@section('content')
<div id="no-js">
   <noscript>
        <meta http-equiv="refresh" content="0; URL=JavaScript-disabled">
        <style type="text/css">#form-content {display: none;}</style>
    </noscript>
</div>
    
<div id="form-content">
<center><h1>Ambiente de Prueba</h1></center>
         @if (Session::has('fail_to_change'))
           <div class="woocommerce-message woocommerce-tracker" >
                <p id="fail">{!!Session::get('fail_to_change')!!}</p>
            </div>
         @endif
<?php
define('PROBE_VERSION', '1.0');
define('PROBE_FOR', 'PlataformaEscolar HELPDESK '. Config::get('app.version'));
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
?>

<div id="wrapper">
    <h1>Prueba de Entorno</h1>

        <b>Versión de Prueba:</b>
        <?php echo PROBE_VERSION?>
        <br>
        <b>Prueba para:</b>
        <?php echo PROBE_FOR?>
        <br/>
        <br/>
    Esta prueba verificará los requisitos previos necesarios para instalar PlataformaEscolar.
    
    <br/><br/>
    <p>NOTE:&nbsp;PLATAFORMAESCOLAR no funciona correctamente sin JavaScript. Para instalar y utilizar PLATAFORMAESCOLAR en toda su capacidad, asegurese de tener habilitado JavaScript en su navegador.</p>
     <?php

function validate_php(&$results) {
    if (version_compare(PHP_VERSION, '8.1') != 1) {
        $results[] = new TestResult('La versión de PHP requerida para ejecutar PlataformaEscolar HELPDESK es PHP 8.1.*. Las versiones de PHP mayores o menores a 8.1 no son compatibles aún. Su versión de PHP es: ' . PHP_VERSION, STATUS_ERROR);
        return false;
    } else {
        $results[] = new TestResult('Su versión de PHP es ' . PHP_VERSION, STATUS_OK);
        return true;
    } // if
} // validate_php

/**
 * Convert filesize value from php.ini to bytes
 *
 * Convert PHP config value (2M, 8M, 200K...) to bytes. This function was taken  from PHP documentation. $val is string
 * value that need to be converted
 *
 * @param string $val
 * @return integer
 */
function php_config_value_to_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val) - 1]);
    $val = (integer)$val;
    switch ($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    } // if

    return (integer) $val;
} // php_config_value_to_bytes

/**
 * to check file permissions 
 *
 */
function checkFilePermission(&$results)
{
    $path2 = base_path().DIRECTORY_SEPARATOR.'storage';
    $f2 = substr(sprintf("%o",fileperms($path2)),-3);
    if (file_exists(base_path() . DIRECTORY_SEPARATOR . "example.env")) {
        $path1 = base_path().DIRECTORY_SEPARATOR.'example.env';
        $f1 = substr(sprintf("%o",fileperms($path1)),-3);
    } else {
        $f1 = '644';
    }
    if( $f1 >= '644' && $f2 >= '755') {
        $results[] = new TestResult('Los permisos del archivo parecen correctos.', STATUS_OK);
        return true;
    } else {
        if(isset($path1)){
        $results[] = new TestResult('Se requieren permisos de archivo. <ul><b>Cambie permisos de archivo para los siguientes archivos</b><li>'.$path1.'%nbsp: \'644\'</li><li>'.$path2.'%nbsp: \'755\'</li></ul></br>Cambie el permiso manualmente en su servidor o <a href="change-file-permission">click aquí.</a>', STATUS_ERROR);
        } else {
            $results[] = new TestResult('Se requieren permisos de archivo. <ul><b>Cambie permisos de archivo para los siguientes archivos</b><li>'.$path2.'</li></ul></br>Cambie el permiso manualmente en su servidor o <a href="change-file-permission">click aquí.</a>', STATUS_ERROR);
        }
        return false;
    }
}

/**
 * Validate memory limit
 *
 * @param array $result
 */
function validate_memory_limit(&$results) {
    $memory_limit = php_config_value_to_bytes(ini_get('memory_limit'));

    $formatted_memory_limit = $memory_limit === -1 ? 'unlimited' : format_file_size($memory_limit);

    if ($memory_limit === -1 || $memory_limit >= 67108864) {
        $results[] = new TestResult('Your memory limit is: ' . $formatted_memory_limit, STATUS_OK);
        return true;
    } else {
        $results[] = new TestResult('Tu límite de memoria es muy bajo para completar la instalación. El valor mínimo es 64MB, y tienes configurado ' . $formatted_memory_limit, STATUS_ERROR);
        return false;
    } // if
} // validate_memory_limit

/**
 * Format filesize
 *
 * @param string $value
 * @return string
 */
function format_file_size($value) {
    $data = [
        'TB' => 1099511627776,
        'GB' => 1073741824,
        'MB' => 1048576,
        'kb' => 1024,
    ];

    // commented because of integer overflow on 32bit sistems
    // http://php.net/manual/en/language.types.integer.php#language.types.integer.overflow
    // $value = (integer) $value;
    foreach ($data as $unit => $bytes) {
        $in_unit = $value / $bytes;
        if ($in_unit > 0.9) {
            return trim(trim(number_format($in_unit, 2), '0'), '.') . $unit;
        } // if
    } // foreach

    return $value . 'b';
} // format_file_size

function validate_zend_compatibility_mode(&$results) {
    $ok = true;

    if (version_compare(PHP_VERSION, '5.0') >= 0) {
        if (ini_get('zend.ze1_compatibility_mode')) {
            $results[] = new TestResult('zend.ze1_compatibility_mode está configurado en Activado. Esto puede causar problemas extraños. Se recomienda encarecidamente cambiar este valor a Off (en su archivo php.ini)', STATUS_WARNING);
            $ok = false;
        } else {
            $results[] = new TestResult('zend.ze1_compatibility_mode está configurado en Desactivado', STATUS_OK);
        } // if
    } // if

    return $ok;
} // validate_zend_compatibility_mode

function validate_extensions(&$results) {
    $ok = true;

    $required_extensions = ['curl', 'ctype', 'imap', 'mbstring',
        'openssl', 'tokenizer', 'zip', 'pdo', 'mysqli', 'bcmath',
       'iconv', 'xml', 'json'];

    foreach ($required_extensions as $required_extension) {
        if (extension_loaded($required_extension)) {
            $results[] = new TestResult("Extension requerida '$required_extension' found", STATUS_OK);
        } else {
            $results[] = new TestResult("Extension '$required_extension' es requerida para ejecutar PlataformaEscolar Helpdesk ", STATUS_ERROR);
            $ok = false;
        } // if
    } // foreach

    // Check for eAccelerator
    if (extension_loaded('eAccelerator') && ini_get('eaccelerator.enable')) {
        $results[] = new TestResult("eAccelerator opcode cache activo. <span class=\"details\">eAccelerator opcode cache causa que PlataformaEscolar Helpdesk colapse. <a href=\"https://eaccelerator.net/wiki/Settings\">Deshabilitarlo</a> para la carpeta donde está instalado PlataformaEscolar Helpdesk, o usar APC en su lugar: <a href=\"http://www.php.net/apc\">http://www.php.net/apc</a>.</span>", STATUS_ERROR);
        $ok = false;
    } // if

    // Check for XCache
    if (extension_loaded('XCache') && ini_get('xcache.cacher')) {
        $results[] = new TestResult("XCache opcode cache activo. <span class=\"details\">XCache opcode cache causa que PlataformaEscolar Helpdesk colapse. <a href=\"http://xcache.lighttpd.net/wiki/XcacheIni\">Deshabilitarlo</a> para la carpeta donde está instalado PlataformaEscolar Helpdesk, o usar APC en su lugar: <a href=\"http://www.php.net/apc\">http://www.php.net/apc</a>.</span>", STATUS_ERROR);
        $ok = false;
    } // if

    $recommended_extensions = [
        // 'imap' => 'IMAP extension is used for connecting to mail server using IMAP settings to fetch emails in the system.',
        // 'mcrypt' => 'Optional extension',
        // 'gd' => 'GD is used for image manipulation. Without it, system is not able to create thumbnails for files or manage avatars, logos and project icons. Please refer to <a href="http://www.php.net/manual/en/image.installation.php">this</a> page for installation instructions',
        // 'mbstring' => 'MultiByte String is used for work with Unicode. Without it, system may not split words and string properly and you can have weird question mark characters in Recent Activities for example. Please refer to <a href="http://www.php.net/manual/en/mbstring.installation.php">this</a> page for installation instructions',
        // 'curl' => 'cURL is used to support various network tasks. Please refer to <a href="http://www.php.net/manual/en/curl.installation.php">this</a> page for installation instructions',
        // 'iconv' => 'Iconv is used for character set conversion. Without it, system is a bit slower when converting different character set. Please refer to <a href="http://www.php.net/manual/en/iconv.installation.php">this</a> page for installation instructions',
        // 'imap' => 'IMAP is used to connect to POP3 and IMAP servers. Without it, Incoming Mail module will not work. Please refer to <a href="http://www.php.net/manual/en/imap.installation.php">this</a> page for installation instructions',
        // 'zlib' => 'ZLIB is used to read and write gzip (.gz) compressed files',
        // SVN extension ommited, to avoid confusion
    ];

    foreach ($recommended_extensions as $recommended_extension => $recommended_extension_desc) {
        if (extension_loaded($recommended_extension)) {
            $results[] = new TestResult("Extension recomendada '$recommended_extension' encontrada", STATUS_OK);
        } else {
            $results[] = new TestResult("La extensión '$recommended_extension' no fue encontrada. <span class=\"details\">$recommended_extension_desc</span>", STATUS_WARNING);
        } // if
    } // foreach

    return $ok;
} // validate_extensions

/**
 * function to check if there are laravel required functions are disabled
 */
function checkDisabledFunctions(&$results) {
    $ok = true;
    $sets = explode(",", ini_get('disable_functions'));
    $required_functions = ['escapeshellarg'];
    // dd($required_functions,$sets);
    foreach ($sets as $key) {
        $key = trim($key);
        foreach ($required_functions as $value) {
            if($key == $value) {
                if (strpos(ini_get('disable_functions'), $key) !== false) {
                    $results[] = new TestResult("Función '$value' es requerida para ejecutar PlataformaEscolar Helpdesk. Por favor, verifica el archivo php.ini para habilitar esta función o contacta a tu administrador de servidor", STATUS_ERROR);
                    $ok = false;
                } else {
                    $results[] = new TestResult("Todas las funciones requeridas encontradas", STATUS_OK);
                }
            }
        }
    }
    return $ok;
}

function checkMaxExecutiontime(&$results)
{
    $ok = true;
    if ((int)ini_get('max_execution_time') >=  120) {
        $results[] = new TestResult("El tiempo máximo de ejecución se ajusta a los requisitos.", STATUS_OK);
    } else {
        $results[] = new TestResult("El tiempo máximo de ejecución es demasiado bajo. El tiempo de ejecución recomendado es de 120 segundos ", STATUS_WARNING);
    }
    return $ok;
}

// ---------------------------------------------------
//  Do the magic
// ---------------------------------------------------

$results = [];

$php_ok = validate_php($results);
$memory_ok = validate_memory_limit($results);
$extensions_ok = validate_extensions($results);
$file_permission = checkFilePermission($results);
$required_functions = checkDisabledFunctions($results);
$check_execution_time = checkMaxExecutiontime($results);
?>
<p class="setup-actions step">
<?php 
foreach ($results as $result) {
    print '<span class="' . strtolower($result->status) . '">' . $result->status . '</span> &mdash; ' . $result->message . '<br/>';
} // foreach
?>
</p>
<?php
if ($php_ok && $memory_ok && $extensions_ok && $file_permission && $required_functions && $check_execution_time) {
    ?>
</div>  

            <div class="woocommerce-message woocommerce-tracker" >
                <p id="pass">De acuerdo, este sistema puede ejecutar PlataformaEscolar Helpdesk.</p>
            </div>


    <form action="{{URL::route('postprerequisites')}}" method="post"  class="border-line">
        {{ csrf_field() }}
        <p class="setup-actions step">
            <input type="submit" id="submitme" class="button-primary button button-large button-next" value="Continuar">
            <a href="{!! route('licence') !!}" class="button button-large button-next" style="float: left">Anterior</a>
        </p>
    </form>
</br>
    <?php
} else {

    ?></div><br>
            
            <div class="woocommerce-message woocommerce-tracker" >
                <p id="fail">Este sistema no cumple con los requisitos del sistema PlataformaEscolar Helpdesk.</p>
            </div>
<p class="setup-actions step">
    <a href="{{URL::route('licence')}}" style="float: left"><button value="prev" class="button-primary button button-large">Anterior</button></a>
    <button disabled="" class="button-primary button button-large button-next" style="float: right">Continuar</button>
</p> <?php
}
?>

<div id="legend">
        {{-- <ul> --}}
                    @include('themes.default1.installer.components.info-procces-install')
        {{-- </ul> --}}
      </div>
</div>
</div>
@stop
