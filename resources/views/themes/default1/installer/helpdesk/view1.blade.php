@extends('themes.default1.installer.layout.installer')
@section('environment')
done
@stop
@section('license')
active
@stop
@section('content')
    <div id="form-content">
        <center><h1>Acuerdo de Licencia</h1></center>

        <p>Lea atentamente este acuerdo de licencia de software antes de descargar o utilizar el software. Al hacer clic en el botn "Aceptar", abrir el paquete o descargar el producto, usted acepta quedar sujeto a los terminos de este acuerdo. Si no acepta todos los terminos de este acuerdo, interrumpa el proceso de instalacion y salga.</p>
        <form action="{{URL::route('postlicence')}}" method="post">
            {{ csrf_field() }}
            <div>
                
                <div id="openModal" class="modalDialog">
                    <div>
                        <a href="#close" title="Close" class="close">X</a>
                        <div div class="modal-body">
                            <h1>
                            ACUERDO DE LICENCIA DE USUARIO FINAL
                            </h1>
                            <p>
                            ESTE "ACUERDO DE LICENCIA DE USUARIO FINAL" (EL "EULA") ES UN ACUERDO LEGAL ENTRE LA PERSONA FÍSICA O LA ENTIDAD O ASOCIACIÓN QUE PRETENDE USAR EL SOFTWARE ("USTED" O "CLIENTE") Y PlataformaEscolar. AL REGISTRARSE PARA EL SOFTWARE O AL USAR EL SOFTWARE, USTED DECLARA, GARANTIZA Y ACEPTA QUE HA LEÍDO, ENTENDIDO Y ACEPTA ESTAR OBLIGADO POR LOS TÉRMINOS DEL EULA. SI NO ACEPTA ESTAR OBLIGADO POR EL EULA, O NO TIENE AUTORIDAD PARA VINCULAR AL CLIENTE AL EULA, NO PUEDE USAR EL SOFTWARE.
                            </p>
                            <h2>
                            Definiciones
                            </h2>
                            <p>
                            <strong>
                            "Cuenta de Usuario de Personal Activa"
                            </strong>
                            significa una cuenta de usuario de staff que está activa en el contexto del software de PlataformaEscolar, es decir, que la cuenta es totalmente funcional y puede usarse para autenticarse en el Software.
                            </p>
                            <p>
                            <strong>
                            "Datos"
                            </strong>
                            significa los datos almacenados en su mesa de ayuda usando el Software.
                            </p>
                            <p>
                            <strong>
                            "Nombre de Dominio"
                            </strong>
                            significa un nombre de dominio de Internet (por ejemplo, sub.domain.com y domain.com).
                            </p>
                            <p>
                            <strong>
                            "Clave de Licencia"
                            </strong>
                            significa la clave que se utiliza para activar el Software para su uso por el Cliente.
                            </p>
                            <p>
                            <strong>
                            "Sitio"
                            </strong>
                            significa www.PlataformaEscolar.org.
                            </p>
                            <p>
                            <strong>
                            "Software"
                            </strong>
                            significa el software que acompaña a este EULA.
                            </p>
                            <p>
                            <strong>
                            "Solución"
                            </strong>
                            significa la solución (PlataformaEscolar Helpdesk, PlataformaEscolar Service Desk) que Usted elija recibir como parte del Software.
                            </p>
                            <p>
                            <strong>
                            "Cuenta de Usuario de Personal"
                            </strong>
                            significa una cuenta de staff/agente en el contexto del software de PlataformaEscolar.
                            </p>
                            <p>
                            <strong>
                            "Soporte y Mantenimiento"
                            </strong>
                            significa la suscripción opcional de pago que permite a un Cliente recibir acceso a soporte y a nuevas versiones y actualizaciones del Software.
                            </p>
                            <p>
                            <strong>
                            "Software de Terceros"
                            </strong>
                            incluye cualquier software de terceros que pueda estar incluido con el Software.
                            </p>
                            <h2>
                            1. Concesión de la licencia
                            </h2>
                            <h3>
                            1.1 Licencia
                            </h3>
                            <p>
                            Sujeto al EULA y siempre que disponga de una Clave de Licencia válida, PlataformaEscolar le concede a Usted la licencia revocable, no exclusiva, no transferible y no sublicenciable para usar el Software mediante sus Cuentas de Usuario de Personal Activas.
                            </p>
                            <h3>
                            1.2 Cuentas de Usuario de Personal
                            </h3>
                            <p>
                            Debe asegurarse de que el número de sus Cuentas de Usuario de Personal Activas sea igual o inferior al número de Cuentas de Usuario de Personal por las que se ha suscrito. Usted es responsable de garantizar que el acceso a una Cuenta de Usuario de Personal no se comparta. Solo una persona podrá autenticarse con una Cuenta de Usuario de Personal. Si Usted es una entidad legal o asociación, todas las personas que usen sus Cuentas de Usuario de Personal deben ser sus empleados o contratistas que hayan aceptado regirse por el EULA. El hardware o software que utilice para agrupar conexiones, redirigir información o reducir el número de usuarios que acceden o utilizan directamente el Software (a veces denominado "multiplexación" o "pooling") no reduce el número de licencias o de Cuentas de Usuario de Personal Activas que necesita.
                            </p>
                            <h3>
                            1.3 Software de Terceros
                            </h3>
                            <p>
                            El Software puede contener o acompañarse de Software de Terceros que requiera avisos y/o términos y condiciones adicionales. Tales avisos y/o términos adicionales podrán solicitarse a PlataformaEscolar y se incorporan por referencia al EULA. Al aceptar el EULA, Usted también acepta los términos y condiciones adicionales, si los hubiera, establecidos en los mismos.
                            </p>
                            <h3>
                            1.4 Nuevas versiones, actualizaciones y aumentos en el número de Cuentas de Usuario de Personal
                            </h3>
                            <p>
                            Tiene derecho a usar nuevas versiones y actualizaciones del Software y/o a aumentar el número de sus Cuentas de Usuario de Personal únicamente
                            </p>
                            <p>
                            (i) si opta por contratar una suscripción de Soporte y Mantenimiento y
                            </p>
                            <p>
                            (ii) mientras su suscripción de Soporte y Mantenimiento permanezca activa y en regla. La suscripción de Soporte y Mantenimiento es opcional y, sujeto a los términos del EULA, Usted puede usar el Software sin dicha suscripción y/o continuar usando el Software una vez que la suscripción haya expirado. Cualquier nueva versión o actualización del Software que reciba y a la que tenga derecho conforme a esta Sección 1.4 se incluirá en la definición de "Software" y se regirá por los términos de este EULA, a menos que dicha nueva versión o actualización vaya acompañada de una licencia separada, en cuyo caso regirán los términos de esa licencia. Solo podrá obtener nuevas versiones y/o actualizaciones del Software de PlataformaEscolar u otras fuentes autorizadas por PlataformaEscolar.
                            </p>
                            <h2>
                            2. Condiciones y limitaciones
                            </h2>
                            <h3>
                            2.1 Número de instalaciones
                            </h3>
                            <p>
                            Se le permite únicamente
                            </p>
                            <p>
                            (i) una instalación en vivo y accesible del Software y
                            </p>
                            <p>
                            (ii) una instalación privada disponible exclusivamente para el Cliente con fines de prueba internos. Cada instalación en vivo del Software puede accederse a través de un solo Nombre de Dominio. Si se requiere acceso mediante varios Nombres de Dominio, se necesitarán licencias adicionales.
                            </p>
                            <h3>
                            2.2 No reventa, tiempo compartido ni sublicenciamiento
                            </h3>
                            <p>
                            No deberá licenciar, sublicenciar, vender, revender, alquilar, arrendar, transferir, ceder, distribuir, compartir en el tiempo ni explotar comercialmente ni poner el Software a disposición de terceros, salvo lo expresamente permitido por el EULA.
                            </p>
                            <h3>
                            2.3 No uso ilegal ni contenido objetable
                            </h3>
                            <p>
                            No deberá usar el Software de forma ilegal ni de manera que interfiera o altere la integridad o el rendimiento del Software y sus componentes, ni que infrinja los derechos de terceros. No deberá modificar, adaptar ni vulnerar partes protegidas (encriptadas o compiladas) del Software, ni intentar obtener acceso no autorizado a dichas partes o a los sistemas o redes asociados. Se compromete a no promover material ilegal, amenazante, abusivo, malicioso, difamatorio, falso, materialmente inexacto o de otro modo objetable. No reproducirá, publicará ni distribuirá contenido que infrinja la marca, los derechos de autor, la patente, el secreto comercial, el derecho de publicidad, la privacidad u otro derecho de propiedad de terceros. PlataformaEscolar no garantiza que el uso del Software conforme al EULA no viole leyes o normativas aplicables a Usted.

                                </p>
                                </p>
                                </p>
                            </p>
                            </p>
                            </p>
                            </p>

                            <br>
                        </div>
                            <a style="float: right;" href="#" title="Close" class="button-primary button button-large button-next">Close</a>
                        </p>

                    </div>
                </div>
                <input id="Acceptme" class="input-checkbox" name="acceptme" type="checkbox">
            <label for="Acceptme">Acepto el <a href="#openModal">Acuerdo de Licencia</a></label>
            </div>
            <br>
            <p class="setup-actions step">
                <input type="submit" id="submitme" class="button-primary button button-large button-next" value="Continuar" name="accept1">
                <a href="{!! route('prerequisites') !!}" class="button button-large button-next" style="float: left">Anterior</a>
            </p>
            <br>
        </form>
        </div>
    <script>
        window.onload = function() {
            if(!window.location.hash) {
                window.location = window.location + '#loaded';
                window.location.reload();
            }
        }
        var second = document.getElementById('Acceptme').checked = false;
        var first = document.getElementById('submitme').disabled = true;
        var checkme = document.getElementById('Acceptme');
        var submiter = document.getElementById('submitme');

        checkme.onchange = function() {
            submiter.disabled = !this.checked;
            if (submiter.disabled) {
                //    alert("Click to enable the button");
            };
        };
    </script>
    

@stop