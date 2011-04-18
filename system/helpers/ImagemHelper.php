<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Imagem
 *
 * @author Honjoya
 */
class ImagemHelper {

    public $tipos_permitidos = array('png','jpg','gif','bmp');
    public $tamanho_max = 900000;
    public $tipo = null;

    public function checkImage($file){
        
        $tipo_imagem = explode('/',$file['type']);
        $this->tipo = $tipo_imagem[1];
        if(in_array($tipo_imagem[1], $this->tipos_permitidos)){

        }else{
            return 'Tipo não permitido';
        }

        if($file['size'] > $this->tamanho_max){
            return 'Tamanho máximo excedido';
        }
        return true;
    }

    public function saveImage($file,$name = null,$caminho = null,$width = null,$height = null){

        require_once('/webroot/vendor/wideimage/WideImage.php');

        if($name    === null) die('Nome não informado para a imagem');
        if($caminho === null) die('Caminho destino não informado');
        
        if(!is_dir(ltrim($caminho,'/'))) mkdir($caminho,0770);

        $tmp = $file['tmp_name'];
        $tmp = WideImage::load($tmp);

        if($width != null || $height != null)
            $tmp = $tmp->resize($width,$height);
      
      
        if($this->tipo === null) die('Metodo de validação checkImage() não chamado.');
        
        $name = $name.'.'.$this->tipo;

       try{
           $tmp->saveToFile(ltrim($caminho,'/').'/'.$name);
           return true;
       }catch(Exception $e){
           return false;
       }

    }

    public function imprimeImagem($caminho,$title = 'imagem',$alt = 'imagem',$class = null){
        
        if(file_exists(ltrim($caminho,'/')) && is_file(ltrim($caminho,'/'))){
            return "<img class='".$class."' src='".$caminho."' alt='".$alt."'  title='".$title."'/>";
        }else{
            return "<img src='/webroot/img/icons/no_image.png'/>";
        }
    }

    public function deleteImage($caminho){
        $caminho = ltrim($caminho,'/');
       if(file_exists($caminho)){
           try{
               return unlink($caminho);
           }catch(Exceptio $e){
               return false;
           }
       }else{
           return false;
       }
    }
}
?>
