<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of carrinhos_controller
 *
 * @author Honjoya
 */
class Carrinhos extends Controller {
    
     public function cadastrar(){
         if(isset($this->data['get']['oferta'])){
            $idOferta = $this->data['get']['oferta'];
            $_SESSION['carrinho'][] = $idOferta;
         }
         echo json_decode(count($_SESSION['carrinho']));
     }

    public function ver(){
        $this->layout = 'front_end';
        debug($_SESSION['carrinho']);
        $this->autoRender('carrinhos/ver');
    }

    public function excluir(){
        
    }

    public function limpar(){
        
    }

}
?>

