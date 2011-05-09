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
    public $LojaOferta = null;

    public function  __construct() {
        parent::__construct();
        
        if($this->LojaOferta === null){
            $this->LojaOferta = new LojaOferta();
        }
    }


     public function incluir(){
        $oferta = null;
        if(isset($this->data['get']['id']) && !empty($this->data['get']['id'])){
            $sql = "SELECT loja_oferta_imagens.id as imagem_id, loja_oferta_imagens.imagem , loja_oferta.* FROM loja_oferta
                    LEFT JOIN loja_oferta_imagens ON (loja_oferta_imagens.loja_oferta_id = loja_oferta.id)
                    where loja_oferta.id = '".$this->data['get']['id']."'";

            $lojaOferta = new LojaOferta();
            $oferta = $lojaOferta->executeQuery($sql);
        }
        $this->set('oferta',$oferta);
        $this->layout = 'front_end';
        $this->autoRender('carrinhos/incluir');
     }

    public function ver(){
        $this->comprar();
    }

    public function comprar(){

       $ofertas = null;

       $this->layout = 'front_end';
       if(isset($this->data['get']['acao']) && $this->data['get']['acao'] === 'adicionar'):
           if(!is_array( $this->data['get']['id'])){
                $_SESSION['carrinho'][] = $this->data['get']['id'];
           }
       endif;
       if(isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0){
            $carrinho = implode(',',$_SESSION['carrinho']);
            $sql = 'SELECT loja_oferta_imagens.id as id_imagem, loja_oferta_imagens.imagem as imagem, loja_oferta.* FROM loja_oferta
                       LEFT JOIN loja_oferta_imagens ON(loja_oferta_imagens.loja_oferta_id = loja_oferta.id)
                       WHERE loja_oferta.id IN ('.$carrinho.')';

            $ofertas = $this->LojaOferta->executeQuery($sql);

               foreach($_SESSION['carrinho'] as $pcarinhho){
                    foreach($ofertas as $k=>$v):
                        if( $v['id'] == $pcarinhho ){
                           if(!isset($ofertas[$k]['total']))
                               $ofertas[$k]['total'] = 1;
                           else
                               $ofertas[$k]['total']++;
                        }
                    endforeach;
               }
               $this->set('carrinho',$ofertas);
           }

       $this->set('carrinho',$ofertas);
       $this->autoRender('carrinhos/ver');
        
    }

    public function excluir(){
    }

    public function cancelar(){


        foreach($_SESSION['carrinho'] as $k=>$v):
            if($this->data['get']['id'] == $v){
                unset($_SESSION['carrinho'][$k]);
            }
        endforeach;
        
        $this->redirect("/carrinhos/comprar");
    }
}
?>