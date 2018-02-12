<?php
class Upload {
    public static function Files($files) {
        $out = array();
        $error = array();
        $extension=array("jpeg","jpg","png","gif");
        foreach($files["tmp_name"] as $key=>$tmp_name)
        {
            $file_name = $files["name"][$key];
            $file_tmp = $files["tmp_name"][$key];
            $ext    =   pathinfo($file_name,PATHINFO_EXTENSION);
            if(in_array($ext,$extension))
            {
                if(!file_exists(Config::get('Upload/path')."/".str_replace(' ', '_', $file_name)))
                {
                    move_uploaded_file($file_tmp=$files["tmp_name"][$key],Config::get('Upload/path')."/".str_replace(' ', '_', $file_name));
                }
                else
                {
                    move_uploaded_file($file_tmp=$files["tmp_name"][$key],Config::get('Upload/path')."/".str_replace(' ', '_', $file_name));
                }
            }
            else
            {
                array_push($error,"$file_name, ");
            }
            array_push($out, str_replace(' ', '_', $file_name));
        }
        return $out;
    }
}
