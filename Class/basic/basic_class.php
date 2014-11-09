<?php


//obj_debug 使用方式 
/*
$this->obj_debug($debug='off',$tmp_sql='',$query_arr=''); 預設為不執行 debug =off, sql='' , query_array='' 
$this->obj_debug($debug='sql',$tmp_sql,$query_arr=''); 輸出sql
$this->obj_debug($debug='query_arr',$tmp_sql='',$query_arr); 輸出array
<a href="basic_class.php">basic_class.php</a>

*/
//namespace basic;

class  Basic_page{
  protected $table_name;
  protected $tmp_comanyId;
  protected $tmp_order ='order by id asc';
  protected $laout_set=true;
  public    $laout_arr =array();
  protected $tmp_id;
  public $uni;
    function __construct(){
    }
    
    function __destruct(){
    
    }    
    //  將物件屬性組合成sql執行後回傳指定物件陣列為 $this->[參數1][參數2]
    function tmp_select($arr_name='laout_arr',$arr_key='tmp_arr',$debug='off'){
      $tmp_sql='SELECT * FROM '.$this->table_name.'   '.$this->tmp_where.'  '.$this->tmp_order;
      $result=mysql_query($tmp_sql);
	  
      if ($result){        
        while($row = @mysql_fetch_assoc($result)) {
          $this->{$arr_name}[$arr_key][]=$row;
         }
          @mysql_free_result($result);
      }
	  
      if($debug!='off'){
        $this->obj_debug($debug,$tmp_sql,$this->{$arr_name}[$arr_key]);
      }
               
               
    }   
    

  
 //  $basic_sql='select * from news order by id asc ';
 //  $obj_tmp1->tmp_select('tmp_arr',$basic_sql);
 //  執行sql回傳指定物件陣列為 $this->[參數1][參數2][參數4]
    function basic_select($arr_name,$arr_key,$tmp_sql,$arr_subkey='',$debug='off'){
      $result=mysql_query($tmp_sql);
      if($result){
        while($row = @mysql_fetch_assoc($result)) {
            if($arr_subkey =='')
              $this->{$arr_name}[$arr_key][]=$row;
            else
              $this->{$arr_name}[$arr_key][$arr_subkey]=$row;
            }
          @mysql_free_result($result);            
        }

             
      if($debug!='off'){
        $this->obj_debug($debug,$tmp_sql,$this->{$arr_name}[$arr_key]);
      }       
    }
//end basic_select   

    //單純執行sql，沒有回傳
    function basic_sql_run($tmp_sql,$go_back='yes',$debug='off'){  
      if($debug!='off'){
        $this->obj_debug($debug,$tmp_sql,$this->{$arr_name}[$arr_key]);
      }
     
      if($this->laout_set== false){
        if($go_back =='yes'){    
          if(mysql_query($tmp_sql))
            echo "<script language=\"javascript\">location.href='".PAGE_NAME.".php';</script>";
        }
        else{
          mysql_query($tmp_sql); // 成功執行 
        }
      }      
    }
//end basic_sql_run   
    
    //  將物件屬性組合成sql執行
    function edit_update($query_arr,$go_back='yes',$debug='off'){
      //$this->form_valid($query_arr);
      $col_var=html_col_var('update',$query_arr);
      $tmp_sql="update $this->table_name set ".implode(", ",$col_var['var'])." $this->tmp_where ;";
	  
      if($debug!='off'){
        $this->obj_debug($debug,$tmp_sql,$this->{$arr_name}[$arr_key]);
      }
    


      if($this->laout_set== false){
        if($go_back =='yes'){    
          if(mysql_query($tmp_sql))
            echo "<script language=\"javascript\">location.href='".PAGE_NAME.".php';</script>";
        }
        else{
          mysql_query($tmp_sql); // 成功執行
        }
      } 
    }   


    //  將物件屬性組合成sql執行
    function insert_update($query_arr,$go_back='yes',$debug='off'){
      //$this->form_valid($query_arr);
      $col_var=html_col_var('insert',$query_arr);
      $tmp_sql="INSERT INTO `$this->table_name` ( ".implode(', ',$col_var['col'])." ) values ( ".implode(", ",$col_var['var'])." );";
      
      if($debug!='off'){
        $this->obj_debug($debug,$tmp_sql,$this->{$arr_name}[$arr_key]);
      } 
   
   
      if($this->laout_set== false){
        if($go_back =='yes'){    
          if(mysql_query($tmp_sql))
            echo "<script language=\"javascript\">location.href='".PAGE_NAME.".php';</script>";
        }
        else{
          mysql_query($tmp_sql); // 成功執行 
        }
      }  
    }
    //  將物件屬性組合成sql執行
    function delete_update($debug='off'){  
      $tmp_sql="delete from $this->table_name  $this->tmp_where ;";
      if($debug!='off'){
        $this->obj_debug($debug,$tmp_sql,$this->{$arr_name}[$arr_key]);
      }     
  
      if($this->laout_set== false){
        if(mysql_query($tmp_sql))
          echo "<script language=\"javascript\">location.href='".PAGE_NAME.".php';</script>";
          }
    }
    
    
    //語系轉換
    //陣列進陣列出
    function laout_change_lang($tmp_array,$debug='off')
    {
    	foreach($tmp_array as $key => $value)
    	{
    		 if(is_array($value)){ 
      		 if(array_key_exists("lang_key",$value)){
              if($this->laout_arr['lang_arr'][0][$this->lang_set][$value["lang_key"]] !=''){
                $tmp_array[$key]['lang_name']=$this->laout_arr['lang_arr'][0][$this->lang_set][$value["lang_key"]];
              }
			  else
			  {
			  	$tmp_array[$key]['lang_name'] = $value["name"];
			  }
           }
    		  $tmp_array[$key]=$this->laout_change_lang($tmp_array[$key]);
    		}        		
    	}
    	return $tmp_array;
    }
    
    //不可重複資料判斷
    function table_data_unique($table_name, $id, $append_where, $query_arr,$debug='off'){
		
		if(count($query_arr) > 0)
		{
			$num_rows=0;
	      	$col_var=html_col_var('update',$query_arr);
      		$tmp_sql="select * from $table_name where ( ".implode(" or ",$col_var['var'])." ) ";
			if( $append_where != "")
			{
				$tmp_sql .= $append_where;
			}
			if($id != "" || $id != 0)
			{
				$tmp_sql .= " And id <> ".$id;
			}
			      	
    	  	$result=mysql_query($tmp_sql);
		
	      	if ($result){        
        		$num_rows = mysql_num_rows($result);
    	    	@mysql_free_result($result);
	      	}   
      		if($debug!='off'){
    	    	$this->obj_debug($debug,$tmp_sql,$this->laout_arr);
	      	}
		}
		else
		{
			$num_rows = 0;
		}
		
      	return $num_rows; 
    }        
    
    
    //表單md5驗證：只有admin 和本機執行時會寫進資料庫，其他時候就是表單驗證
     function form_valid($query_arr,$debug='off'){  //update
        //admin in valid
      $action=laout_check($_REQUEST['action']);
      if(empty($action)){ $laout=PAGE_NAME.'_preview';$action='preview';}
      else $laout=PAGE_NAME.'_'.$action;
       
      $md5_code=md5(implode(",",array_keys($query_arr)));
      $url=$_SERVER['REQUEST_URI'];
	  
      if(getIP() == '127.0.0.1'  || $decode=='sewrw' || $use_admin =='1'){
        $tmp_select_sql="select * from ".TABLE_NAME."form_valid where action='$action' and `url`='$url' and `laout_html`='$laout'";
        $result=mysql_query($tmp_select_sql);
        $num_rows = mysql_num_rows($result);  
          if($num_rows==1){
            $tmp_sql="update form_valid set action='$action', laout_html='$laout', md5='$md5_code',url='$url'";           
            mysql_query($tmp_sql);
          }
          elseif($num_rows==0){
            $tmp_sql="INSERT INTO `form_valid` (`id` ,`action` ,`laout_html`,`md5`,url) VALUES (null, '$action', '$laout','$md5_code','$url');";
            mysql_query($tmp_sql);
          }
          else{
            echo $tmp_select_sql;
            echo '<br />同一動作，同一表單，相同md5有兩個';
            exit;
          }
      }
      else{
        //from md5 valid
        $tmp_select_sql="select * from form_valid where action='$action' and md5='$md5_code' and laout_html='$laout'";
        $result=mysql_query($tmp_select_sql);
        $num_rows = mysql_num_rows($result);
          if($num_rows!=1){
            echo '操作錯誤';
            exit;
          }
      }
    }
	
    //  指定輸出html
    function laout($action,$debug='off'){
      $this->laout_arr=$this->laout_change_lang($this->laout_arr);      
     
      if($debug!='off'){
        $this->obj_debug($debug,$tmp_sql,$this->laout_arr);
      }
       
      if($this->laout_set == true)
        include_once 'templates/'.$action;
      else
        include_once 'templates/msg.htm';
    }
    
    //  除錯函數，請看最上方
    function obj_debug($debug='off',$tmp_sql='',$query_arr=''){

      if(getIP() == '127.0.0.1' || $decode=='sewrw' || $use_admin =='1'){
        if($debug =='sql'){
          echo $tmp_sql;
          exit;
        }
            
        if($debug =='query_arr'){
          echo '<pre>';
          print_r($query_arr);
          echo '</pre>';
          exit;
        }
      }
      
    }


    function __get($property_name)
    { 
    
        return isset($this->$property_name) ? $this->$property_name : null;
    }
        
        
    function __set($property_name, $value)
    { 
    
        $this->$property_name = $value; 
        return true;
    } 

//加解密用
    function encode($string)
    {
      $encode_string = $string;
      for($i=0;$i<3;$i++)
      {
        $encode_string = base64_encode($encode_string);
      }
      return $encode_string;
    }
    function decode($encode_string)
    {
      $string = $encode_string;
      for($i=0;$i<3;$i++)
      {
        $string = base64_decode($string);
      }
      return $string;
    }
//數字轉字母
    function numToLetter($num){
      $num = intval($num);
      if ($num <= 0)
          return false;
      $letterArr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
      $letter = '';
      do {
          $key = ($num - 1) % 26;
          $letter = $letterArr[$key] . $letter;
          $num = floor(($num - $key) / 26);
      } while ($num > 0);
      return $letter;
    }

    function getIP ()
    {
        global $_SERVER;
        if (getenv('HTTP_CLIENT_IP')) {
        echo $ip = getenv('HTTP_CLIENT_IP');
        exit;
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('REMOTE_ADDR')) {
        $ip = getenv('REMOTE_ADDR');
        } else {
        $ip = $_SERVER['REMOTE_ADDR'];
        }
        @list($a,$b,$c,$d)=explode('.',$ip);
        $a=(int)$a;  $b=(int)$b;  $c=(int)$c;  $d=(int)$d;
        if($a<=255 && $a>=0 && $b<=255 && $b>=0 && $c<=255 && $c>=0 && $d<=255 && $d>=0){$ip="$a.$b.$c.$d";}
        else{$ip=false;}
        return $ip;
    }
	function curPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
		}
    function record_sort($records, $field, $reverse=false)
    {
      $hash = array();
      foreach($records as $record)
      {
          $hash[$record[$field]] = $record;
      }
      
      ($reverse)? krsort($hash) : ksort($hash);
      
      $records = array();
      
      foreach($hash as $record)
      {
          $records []= $record;
      }
      
      return $records;
    }

}


?>