<?php

class AcessControl extends Model {

    static function verificaAcesso($controller,$action){

        $sql = "SELECT * FROM acesso WHERE endereco LIKE '%/".$controller."/".$action."%'";
        $model = new Model();
        $regra = $model->executeQuery($sql);
  
        if(!empty($regra)){
            if(isset($_SESSION['login'])){
                $verificador = false;

               foreach($regra as $v){
                    if($_SESSION['login']['loja_grupo_id'] == $v['loja_usuario_grupo']){
                        $verificador = true;
                    }
                }
                if($verificador == false){
                        header('LOCATION:/login&erro=20');
                }
            }else{
                header('LOCATION:/login');
            }
        }
    }
}
?>
