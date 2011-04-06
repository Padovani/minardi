<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grupo
 *
 * @author Honjoya
 */
class Grupo extends Model {
    public $_tabela = 'loja_usuario_grupos';

    public function getGrupos(){
        return $this->read();
    }
}
?>
