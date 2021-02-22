<?php
namespace App\Http\Traits;


use SoftCreatR\MimeDetector\MimeDetector;

trait validFile{

    public static function valid($file)
    {
        $allowedFiles = ['pdf', 'jpeg', 'jpg', 'png'];
        $mimeDetector = new MimeDetector();
        $mimeDetector->setFile($file);
        $fileData = $mimeDetector->getFileType();

        if (isset($fileData["ext"])){
            $aux = false;
            foreach ($allowedFiles as $ext){
                if ($ext == $fileData["ext"]){
                    $aux = true;
                }
            }
            return $aux;
        }else return false;
    }
}
