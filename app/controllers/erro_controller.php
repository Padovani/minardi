<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of error
 *
 * @author Honjoya
 */
class Erro extends Controller {
    //put your code here

    public function sem_acesso(){
        $this->autoRender('/erro/sem_acesso');
    }

}
?>
