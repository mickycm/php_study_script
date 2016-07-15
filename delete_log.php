<?php

/*
 *删除7天以前的日志
 *
 */
date_default_timezone_set('PRC');
error_reporting(0);
class DeleteLog{
    //以下目录 都是临时目录   需要删除
    public $log_dir =[];
    
    public $outTime = '';   //超时时间 默认 1星期前
    
    public $filesRecord = [];
    
    public function __construct(){
        $this->outTime = date("Y-m-d",strtotime("-3 day"));  //初始化
        $this->filesRecord['del_dir'] = 0;
        $this->filesRecord['del_files'] = 0;
		$this->filesRecord['time'] = date("Y-m-d H:i:s");
    }
    
    //删除超时的目录文件
   public function deleteFile($dir,$outtime = ''){
        $file = [];
        $this->listFiles($dir,$file);
        if($outtime == ''){
            $outtime = date("Y-m-d");   //默认为当前时间  就是删除所有文件
        }
        $outtime = strtotime($outtime);
    
        foreach($file as $k => $v){
             
            $filetime = filemtime($v);
            if($filetime <= $outtime && !stripos($v, '.svn')){   //过期的  除去svn 目录的
                unlink($v);
                echo '已删除文件:'.$v.PHP_EOL;
                $this->filesRecord['del_files'] += 1;   //记录删除文件的个数
            }
    
        }//end foreach
    }//end func
    
    //遍历LOG目录所有文件
   public function listFiles($dir,&$files){
    
        if(!is_dir($dir)){
            $files[] = $dir;
            return ;
        }
        
            //尝试删除空的目录    要除去 session 的目录  
            if(!stripos($dir, 'session_temp') && !stripos($dir, '.') && !in_array($dir, $this->log_dir)){
                $do = rmdir($dir);   
                if($do){
                    $this->filesRecord['del_dir'] += 1;
                    $this->filesRecord['del_dir_name'] .= '目录:'.$dir.'已删除'.PHP_EOL;
                }else{
                    $this->filesRecord['del_dir_fail'] .= '删除目录'.$dir.'失败'.PHP_EOL;
                }
            }
            
        $dirRead = scandir($dir);
        foreach($dirRead as $k => $v){
            //是文件就直接加入数组
            if(!is_dir($dir.'/'.$v)&& $v != '.' && $v != '..'){
                $files[] = $dir.'/'.$v;
            }
            //是目录就继续遍历
            elseif(is_dir($dir.'/'.$v) && $v!='.' && $v!='..'){
                $this->listFiles($dir.'/'.$v,$files);
            }
        }
    }//end function 
    
    /**
     * 开始删除 
     */
    public function delete(){
        foreach($this->log_dir as $k => $v){
            $this->deletefile($v,$this->outTime);
        }
    }//end
    
    
}//end class

$do = new DeleteLog();
$do->log_dir = ['/var/www/ycms.szlanyou.com/lanyoucar_logs',   //拼车日志目录
            '/var/www/html/temp_file',       //PHP临时上传目录
            '/var/www/ycms.szlanyou.com/webroot/Public/upload',    //用户上传图片临时目录
            '/tmp/session_temp',            //session 目录
            '/var/www/ycms.szlanyou.com/dingdang/Runtime/Logs',   //tp 的logs
            '/var/www/nissan.szlanyou.com/portal/portal/logs',   //nissan 开发环境log
    ];

$do->delete();

$str = '已删除'.$do->outTime .'之前的日志文件'.PHP_EOL.',共删除文件:'.$do->filesRecord['del_files'] . '个,目录:'.$do->filesRecord['del_dir'].'个'.PHP_EOL;
echo $str;
print_r($do->filesRecord);