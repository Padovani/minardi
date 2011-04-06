<?php

class AcessControl extends Model {

    static function verificaAcesso($controller,$action){
        $sql = "SELECT * FROM acesso WHERE endereco = '/".$controller."/".$action."' OR endereco = '/".$controller."/*'";
        $model = new Model();

        $regra = $model->executeQuery($sql);

        if(!empty($regra)){
            if(isset($_SESSION['login'])){
                if($_SESSION['login']['loja_grupo_id'] != $regra[0]['loja_usuario_grupo']){
                    header('LOCATION:/erro/sem_acesso');
                }
            }else{
                header('LOCATION:/erro/sem_acesso');
            }
        }
    }
}
?>
