<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');
header('Content-Type: application/json;charset=utf-8'); //return json string
require_once('conn_db.php');

$fileName = $_FILES["file"]["name"];           // The file name
$fileTmpLoc = $_FILES["file"]["tmp_name"];     // File in the PHP tmp folder
$fileType = $_FILES["file"]["type"];           // The type of file it is
$fileSize = $_FILES["file"]["size"];           // File size in bytes
$fileErrorMsg = $_FILES["file"]["error"];      // 0 for false... and 1 for true
$sFolder="uploads";                             // default upload folder 

// get web save upload folder 
if(isset($_POST['sFolder']) && $_POST['sFolder']!=''){     
    $sFolder=$_POST['sFolder'];
}
// backoffice upload path
if(isset($_POST['mode']) && $_POST['mode']=='backoffice'){
    $realPath="../".$sFolder;
}else{
    $realPath="../../../".$sFolder;
}
if(!is_dir($realPath)){
    mkdir($realPath);
}
do{ //檢查產生的檔名是否重複
    $newFile=date("YmdHis").rand(100,999).".".pathinfo($fileName, PATHINFO_EXTENSION);
}while(is_file($realPath."/$newFile"));          //find file
if (!$fileTmpLoc) {                                  
    $retcode = array("success" => "false", "msg" => "", "error" =>"上傳暫存檔無法建立！","fileName"=>"");
}elseif(move_uploaded_file($fileTmpLoc, $realPath."/$newFile")){  
    $retcode = array("success" => "true", "msg" => "完成檔案上傳", "error" => "","fileName"=>$newFile);
} else {
    $retcode = array("success" => "false", "msg" => "", "error" => "無法完成檔案上傳","fileName"=>"");
}
echo json_encode($retcode,JSON_UNESCAPED_UNICODE);
exit();
?>