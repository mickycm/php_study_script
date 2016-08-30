1、PHP加密解密PHP加密和解密函数可以用来加密一些有用的字符串存放在数据库里，并且通过可逆解密字符串，该函数使用了base64和MD5加密和解密。function encryptDecrypt($key, $string, $decrypt){     if($decrypt){         $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "12");         return $decrypted;     }else{         $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));         return $encrypted;     } }使用方法如下：//以下是将字符串“Helloweba欢迎您”分别加密和解密 //加密： echo encryptDecrypt('password', 'Helloweba欢迎您',0); //解密： echo encryptDecrypt('password', 'z0JAx4qMwcF+db5TNbp/xwdUM84snRsXvvpXuaCa4Bk=',1);2、PHP生成随机字符串当我们需要生成一个随机名字，临时密码等字符串时可以用到下面的函数：function generateRandomString($length = 10) {     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';     $randomString = '';     for ($i = 0; $i < $length; $i++) {         $randomString .= $characters[rand(0, strlen($characters) - 1)];     }     return $randomString; }使用方法如下：echo generateRandomString(20);3、PHP获取文件扩展名（后缀）以下函数可以快速获取文件的扩展名即后缀。function getExtension($filename){   $myext = substr($filename, strrpos($filename, '.'));   return str_replace('.','',$myext); }使用方法如下：$filename = '我的文档.doc'; echo getExtension($filename);4、PHP获取文件大小并格式化以下使用的函数可以获取文件的大小，并且转换成便于阅读的KB，MB等格式。function formatSize($size) {     $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");     if ($size == 0) {          return('n/a');      } else {       return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);      } }使用方法如下：$thefile = filesize('test_file.mp3'); echo formatSize($thefile);5、PHP替换标签字符有时我们需要将字符串、模板标签替换成指定的内容，可以用到下面的函数：function stringParser($string,$replacer){     $result = str_replace(array_keys($replacer), array_values($replacer),$string);     return $result; }使用方法如下：$string = 'The {b}anchor text{/b} is the {b}actual word{/b} or words used {br}to describe the link {br}itself'; $replace_array = array('{b}' => '<b>','{/b}' => '</b>','{br}' => '<br />'); echo stringParser($string,$replace_array);6、PHP列出目录下的文件名如果你想列出目录下的所有文件，使用以下代码即可：function listDirFiles($DirPath){     if($dir = opendir($DirPath)){          while(($file = readdir($dir))!== false){                 if(!is_dir($DirPath.$file))                 {                     echo "filename: $file<br />";                 }          }     } }使用方法如下：listDirFiles('home/some_folder/');7、PHP获取当前页面URL以下函数可以获取当前页面的URL，不管是http还是https。function curPageURL() {     $pageURL = 'http';     if (!empty($_SERVER['HTTPS'])) {$pageURL .= "s";}     $pageURL .= "://";     if ($_SERVER["SERVER_PORT"] != "80") {         $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];     } else {         $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];     }     return $pageURL; }使用方法如下：echo curPageURL();8、PHP强制下载文件有时我们不想让浏览器直接打开文件，如PDF文件，而是要直接下载文件，那么以下函数可以强制下载文件，函数中使用了application/octet-stream头类型。function download($filename){     if ((isset($filename))&&(file_exists($filename))){        header("Content-length: ".filesize($filename));        header('Content-Type: application/octet-stream');        header('Content-Disposition: attachment; filename="' . $filename . '"');        readfile("$filename");     } else {        echo "Looks like file does not exist!";     } }使用方法如下：download('/down/test_45f73e852.zip');9、PHP截取字符串长度我们经常会遇到需要截取字符串(含中文汉字)长度的情况，比如标题显示不能超过多少字符，超出的长度用…表示，以下函数可以满足你的需求。/*  Utf-8、gb2312都支持的汉字截取函数  cut_str(字符串, 截取长度, 开始长度, 编码);  编码默认为 utf-8  开始长度默认为 0 */ function cutStr($string, $sublen, $start = 0, $code = 'UTF-8'){     if($code == 'UTF-8'){         $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";         preg_match_all($pa, $string, $t_string);         if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";         return join('', array_slice($t_string[0], $start, $sublen));     }else{         $start = $start*2;         $sublen = $sublen*2;         $strlen = strlen($string);         $tmpstr = '';         for($i=0; $i<$strlen; $i++){             if($i>=$start && $i<($start+$sublen)){                 if(ord(substr($string, $i, 1))>129){                     $tmpstr.= substr($string, $i, 2);                 }else{                     $tmpstr.= substr($string, $i, 1);                 }             }             if(ord(substr($string, $i, 1))>129) $i++;         }         if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";         return $tmpstr;     } }使用方法如下：$str = "jQuery插件实现的加载图片和页面效果"; echo cutStr($str,16);10、PHP获取客户端真实IP我们经常要用数据库记录用户的IP，以下代码可以获取客户端真实的IP：//获取用户真实IP function getIp() {     if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))         $ip = getenv("HTTP_CLIENT_IP");     else         if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))             $ip = getenv("HTTP_X_FORWARDED_FOR");         else             if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))                 $ip = getenv("REMOTE_ADDR");             else                 if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))                     $ip = $_SERVER['REMOTE_ADDR'];                 else                     $ip = "unknown";     return ($ip); }使用方法如下：echo getIp();11、PHP防止SQL注入我们在查询数据库时，出于安全考虑，需要过滤一些非法字符防止SQL恶意注入，请看一下函数：function injCheck($sql_str) {      $check = preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/', $sql_str);     if ($check) {         echo '非法字符！！';         exit;     } else {         return $sql_str;     } }使用方法如下：echo injCheck('1 or 1=1');12、PHP页面提示与跳转我们在进行表单操作时，有时为了友好需要提示用户操作结果，并跳转到相关页面，请看以下函数：function message($msgTitle,$message,$jumpUrl){     $str = '<!DOCTYPE HTML>';     $str .= '<html>';     $str .= '<head>';     $str .= '<meta charset="utf-8">';     $str .= '<title>页面提示</title>';     $str .= '<style type="text/css">';     $str .= '*{margin:0; padding:0}a{color:#369; text-decoration:none;}a:hover{text-decoration:underline}body{height:100%; font:12px/18px Tahoma, Arial,  sans-serif; color:#424242; background:#fff}.message{width:450px; height:120px; margin:16% auto; border:1px solid #99b1c4; background:#ecf7fb}.message h3{height:28px; line-height:28px; background:#2c91c6; text-align:center; color:#fff; font-size:14px}.msg_txt{padding:10px; margin-top:8px}.msg_txt h4{line-height:26px; font-size:14px}.msg_txt h4.red{color:#f30}.msg_txt p{line-height:22px}';     $str .= '</style>';     $str .= '</head>';     $str .= '<body>';     $str .= '<div>';     $str .= '<h3>'.$msgTitle.'</h3>';     $str .= '<div>';     $str .= '<h4>'.$message.'</h4>';     $str .= '<p>系统将在 <span style="color:blue;font-weight:bold">3</span> 秒后自动跳转,如果不想等待,直接点击 <a href="{$jumpUrl}">这里</a> 跳转</p>';     $str .= "<script>setTimeout('location.replace(\'".$jumpUrl."\')',2000)</script>";     $str .= '</div>';     $str .= '</div>';     $str .= '</body>';     $str .= '</html>';     echo $str; }使用方法如下：message('操作提示','操作成功！','http://www.helloweba.com/');13、PHP计算时长我们在处理时间时，需要计算当前时间距离某个时间点的时长，如计算客户端运行时长，通常用hh:mm:ss表示。function changeTimeType($seconds) {     if ($seconds > 3600) {         $hours = intval($seconds / 3600);         $minutes = $seconds % 3600;         $time = $hours . ":" . gmstrftime('%M:%S', $minutes);     } else {         $time = gmstrftime('%H:%M:%S', $seconds);     }     return $time; }使用方法如下：$seconds = 3712; echo changeTimeType($seconds);via：http://www.cnblogs.com/helloweba/p/4147125.html