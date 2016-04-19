<?php
function saveImage($image, $dimensions, $new_image){
    
    if (is_file($image))
    {
        $image_file = new Imagick($image);
        if($dimensions != null){
            $dimensions_explode = explode("x", $dimensions);
            $ori_dimen = $image_file->getImageGeometry();
            $ori_width = $ori_dimen['width'];
            $ori_high  = $ori_dimen['height'];
            $width = 0;
            $high  = 0;
            if(trim($dimensions_explode[0]) !== "" && trim($dimensions_explode[1]) !== ""){
                $width  = trim($dimensions_explode[0]);
                $high   = trim($dimensions_explode[1]);
            }else if(trim($dimensions_explode[0]) === ""){
                $a = $ori_high;
                $b = trim($dimensions_explode[1]);
                $c = 100;
                $p = (($b * $c) / $a) / 100;
                $width = $ori_width * $p;
                $high  = $ori_high  * $p;
            }else if(trim($dimensions_explode[1]) === ""){
                $a = $ori_width;
                $b = trim($dimensions_explode[0]);
                $c = 100;
                $p = (($b * $c) / $a) / 100;
                $width = $ori_width * $p;
                $high  = $ori_high  * $p;
            }
            
            $image_file->thumbnailImage($width,$high);
        }
        
        $image_file->writeImage($new_image);
        $image_file->destroy();
    }
}

function viewImage($image, $dimensions = null){
    //usleep(rand(1000000, 2000000)  );
    if (is_file($image))
    {
        $image_file = new Imagick($image);
        if($dimensions != null){
            $dimensions_explode = explode("x", $dimensions);
            $ori_dimen = $image_file->getImageGeometry();
            $ori_width = $ori_dimen['width'];
            $ori_high  = $ori_dimen['height'];
            $width = 0;
            $high  = 0;
            if(trim($dimensions_explode[0]) !== "" && trim($dimensions_explode[1]) !== ""){
                $width  = trim($dimensions_explode[0]);
                $high   = trim($dimensions_explode[1]);
            }else if(trim($dimensions_explode[0]) === ""){
                $a = $ori_high;
                $b = trim($dimensions_explode[1]);
                $c = 100;
                $p = (($b * $c) / $a) / 100;
                $width = $ori_width * $p;
                $high  = $ori_high  * $p;
            }else if(trim($dimensions_explode[1]) === ""){
                $a = $ori_width;
                $b = trim($dimensions_explode[0]);
                $c = 100;
                $p = (($b * $c) / $a) / 100;
                $width = $ori_width * $p;
                $high  = $ori_high  * $p;
            }

            $image_file->adaptiveResizeImage($width,$high);
        }
        $ima = $image_file->getImageBlob();
        $image_file->destroy();
        header("Content-Type: image/jpg");
        echo $ima;
        die();
    }
}

function redirectInter($url = ""){
    header("Location: " . _APPLICACION_URL . $url);
}

function redirect($url){
    header("Location: " . $url);
}
function instance_controller($name){
    $name = trim($name) . '_controller';
    $locaction = _ROOT_CONTROLLER . '/' . $name . '.php';
    if(file_exists($locaction)){
        include_once($locaction);       
    }else{
        header("HTTP/1.0 404 Not Found");
        die();
    }
    return new $name();
}

function explodeObject($object){
    echo '<pre>';
    print_r($object);
    echo '</pre>';
}

function var_dumpObject($object){
    echo '<pre>';
    var_dump($object);
    echo '</pre>';
}

function udate($format, $utimestamp = null) {
  if (is_null($utimestamp))
    $utimestamp = microtime(true);

  $timestamp = floor($utimestamp);
  $milliseconds = round(($utimestamp - $timestamp) * 1000000);

  return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}


function tablaArr($arr){
    ?>
        <table border="2px"> <!-- Lo cambiaremos por CSS -->
            <tr>
           <?php
           
           foreach ($arr as $arr_linea) {       
               foreach ($arr_linea as $key => $value) {
                   
               if(!is_numeric($key)){
           ?> 
           
              <td><?php echo $key?></td>
          <?php
          
                }    
                }
             break;
          }
          ?>
          </tr>
           <?php
           
           foreach ($arr as $arr_linea) {   
               ?><tr><?php
               foreach ($arr_linea as $key => $value) {
                   
               if(!is_numeric($key)){
           ?> 
              <td><?php echo $value?></td>
          <?php
               }
                }
            ?></tr><?php
          }
          ?>
        </table>
        <?php
}


function createZip($rut_zip, $files){
    $zip = new ZipArchive();
    $zip->open($rut_zip,ZipArchive::CREATE);
    foreach ($files as $file) {
        $zip->addFile($file);
    }
    $zip->close();
}

function donwloadFile($archivo,$nombre){
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $nombre . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($archivo));
    readfile($archivo);
    exit;
}


function sendMailGmail($subject, $mails_array, $message, $attachments = array()){
    //Crear una instancia de PHPMailer
    $mail = new PHPMailer();
    //Definir que vamos a usar SMTP
    $mail->IsSMTP();
    //Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
    // 0 = off (producción)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug  = _MAIL_GMAIL_DEBUG;
    //Ahora definimos gmail como servidor que aloja nuestro SMTP
    $mail->Host       = _MAIL_GMAIL_SMTP;
    //El puerto será el 587 ya que usamos encriptación TLS
    $mail->Port       = _MAIL_GMAIL_PORT;
    //Definmos la seguridad como TLS
    $mail->SMTPSecure = _MAIL_GMAIL_SECURE;
    //Tenemos que usar gmail autenticados, así que esto a TRUE
    $mail->SMTPAuth   = _MAIL_GMAIL_AUTH;
    //Definimos la cuenta que vamos a usar. Dirección completa de la misma
    $mail->Username   = _MAIL_GMAIL_USERNAME;
    //Introducimos nuestra contraseña de gmail
    $mail->Password   = _MAIL_GMAIL_PASSWORD;
    //Definimos el remitente (dirección y, opcionalmente, nombre)
    $mail->SetFrom(_MAIL_GMAIL_FROM_MAIL, _MAIL_GMAIL_FROM_NAME);
    //Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
    foreach ($mails_array as $mail_info) {
        $mail->AddAddress($mail_info[0], $mail_info[1]);
    }
    
    //Definimos el tema del email
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    
    foreach ($attachments as $attachment) {
        $mail->AddAttachment($attachment);
    }

    if(!$mail->Send()) {
        echo "Error: " . $mail->ErrorInfo;die();
    } else{
        return true;
    }
}

function scape($text){
    if(!get_magic_quotes_gpc()) $text = addslashes($text);
    return trim($text);
}  

function limpiarCadena($valor)
{   
    $valor = str_ireplace("SELECT","",$valor);
    $valor = str_ireplace("COPY","",$valor);
    $valor = str_ireplace("DELETE","",$valor);
    $valor = str_ireplace("DROP","",$valor);
    $valor = str_ireplace("DUMP","",$valor);
    $valor = str_ireplace(" OR ","",$valor);
    $valor = str_ireplace("LIKE","",$valor);
    $valor = str_ireplace("–","",$valor);
    $valor = str_ireplace("^","",$valor);
    $valor = str_ireplace("[","",$valor);
    $valor = str_ireplace("]","",$valor);
    $valor = str_ireplace("=","",$valor);
    //$valor = str_ireplace("&","",$valor);  $valor = addslashes($valor);
    return $valor;
}

function cleanInput($input) {
 
    $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
        '@<style[^>]*?>.*?</style>@siU'//,    // Elimina las etiquetas de estilo
        //'@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-línea
    );

    $output = preg_replace($search, '', $input);
    return $output;
}

function mres($value)
{
    $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
    $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $value);
}

function filterXSS($val) 
{
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

        // &#x0040 @ search for the hex values
        $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
        // &#00064 @ 0{0,7} matches '0' zero to seven times
        $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
    }

    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                    $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                    $pattern .= ')?';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
         $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
         if ($val_before == $val) {
            // no replacements were made, so exit the loop
            $found = false;
         }
      }
    }

    return $val;
}

function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        
        $input  = trim($input);
        //$input  = cleanInput($input);
        $input = mres($input);
        $input = limpiarCadena($input);
        $input = htmlentities($input);
        $input = htmlspecialchars($input);
        $input = filterXSS($input);
        $tags_perm = array();
        $atrr_perm = array();
        
        if(_TAGS_PERM_POST_GET !== ''){
            $tags_perm = explode(",", _TAGS_PERM_POST_GET);
        }
        
        if(_ATRR_PERM_POST_GET !== ''){
            $atrr_perm = explode(",", _ATRR_PERM_POST_GET);;
        }

        $ifilter = new InputFilter($tags_perm, $atrr_perm);
        $output = $ifilter->process($input);
        
        unset($ifilter);
    }
    
    return $output;
}

function curl_post_async($url, $params = array())
{
    foreach ($params as $key => &$val) {
      if (is_array($val)) $val = implode(',', $val);
        $post_params[] = $key.'='.urlencode($val);
    }
    $post_string = implode('&', $post_params);

    $parts=parse_url($url);

    $fp = fsockopen($parts['host'],
        isset($parts['port'])?$parts['port']:80,
        $errno, $errstr, 30);

    $out = "POST ".$parts['path']." HTTP/1.1\r\n";
    $out.= "Host: ".$parts['host']."\r\n";
    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out.= "Content-Length: ".strlen($post_string)."\r\n";
    $out.= "Connection: Close\r\n\r\n";
    if (isset($post_string)) $out.= $post_string;

    fwrite($fp, $out);
    fclose($fp);
}


function simpleXls($data, $name = 'reporte'){
    header('Content-type: application/vnd.ms-excel;charset=utf-8');
    header("Content-Disposition: attachment; filename=" . $name . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $cont = 0;
    ?>
    <table style="width:100%">
    <?php
    foreach ($data as $field) {
        $cont++;
        
        if($cont === 1){
            ?>
            <tr>
                <?php 
                foreach ($field as $key_head => $value){
                ?>
                <td><?php echo $key_head?></td>
                <?php 
                }
                ?>
            </tr>
            <?php
        }
        
        ?>
        <tr>
            <?php 
            foreach ($field as $key_head => $value){
            ?>
            <td><?php echo $value?></td>
            <?php 
            }
            ?>
        </tr>
        <?php
        
    }
    ?>
    </table>
    <?php
    
    
}
?>