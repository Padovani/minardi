<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categorias_controller
 *
 * @author Honjoya
 */
class categorias extends controller {
    private $categoria = null;
    private $LojaOferta = null;
    private $limit = 10;

    public function  __construct() {
        if($this->categoria === null){
            $this->categoria = new Categoria();
            parent::__construct();
        }

        if($this->LojaOferta === null){
            $this->LojaOferta = new LojaOferta();
        }
    }


    public function index(){
        $categorias = $this->categoria->getCategoriaTree();
        $this->set('categorias',$categorias);
        
        $this->autoRender('/categorias/index');
    }

    public function add(){
        
        if(isset($this->data['post']) && !empty($this->data['post'])){
            $sql = "INSERT INTO loja_categorias (nome,descricao,parent_id,ativo) 
                        VALUES('".$this->data['post']['nome']."','".$this->data['post']['descricao']."','".$this->data['post']['parent_id']."','".$this->data['post']['ativo']."')";
            if($this->categoria->executeQuery($sql)){
                $this->redirect('/categorias/add');
            }            
        }
        $categorias_lista  = $this->categoria->getCategoriaTreeList();
        $this->set('categorias_lista',$categorias_lista);

        $categorias = array();
        
        foreach($categorias_lista as $k => $v){
            $c = $this->categoria->read('first','loja_categorias.id = '.$k);
            $categorias[$k] = $c;
            $categorias[$k]['nome'] = $v;
        }

        $this->set('categorias',$categorias);
        
        $this->autoRender('/categorias/add');
    }


    public function ativar(){
        
        if(isset($this->data['get']['id']) && !empty($this->data['get']['id']) && isset($this->data['get']['status']) && !empty($this->data['get']['status'])){
            if($this->data['get']['status'] == 'status_ativo') $ativo = 0;
            if($this->data['get']['status'] == 'status_desativado') $ativo = 1;
            $sql = 'UPDATE loja_categorias SET ativo = '.$ativo.' WHERE id = '.$this->data['get']['id'];
            
            if($this->categoria->executeQuery($sql)){
               $this->setConfirm('Status alterado com sucesso!');
               $this->redirect($this->referer);
            }
        }
    }

    public function delete(){
        
        if(isset($this->data['get']['id']) && !empty($this->data['get']['id'])){
            $where = 'parent_id = '.$this->data['get']['id'];
            $count = $this->categoria->count($where);
            if($count == 0){
                if($this->categoria->delete('loja_categorias.id = '.$this->data['get']['id'])){
                    $this->setConfirm('Categoria deletada com sucesso!');
                    $this->redirect($this->referer);
                }else{
                    $this->setError("Categoria com sub categorias - impossivel excluir");
                    $this->redirect($this->referer);
                }
            }else{
                $this->setError("Categoria com sub categorias - impossivel excluir");
                $this->redirect($this->referer);
            }
        }
    }

    public function edit(){
     if(isset($this->data['post']) && !empty($this->data['post'])){

         $id = $this->data['post']['id'];
         $this->data['get']['id'] = $id;
         $parent_id = $this->data['post']['parent_id'];
         $nome = $this->data['post']['nome'];
         $descricao = $this->data['post']['descricao'];
         $ativo = $this->data['post']['ativo'];

         $sql = "UPDATE loja_categorias SET parent_id = '{$parent_id}',nome = '{$nome}', descricao = '{$descricao}', ativo = '{$ativo}' where id = {$id}";

         if($this->categoria->executeQuery($sql)){
             $this->setConfirm('Categoria Alterada com sucesso.');
         }else{
             $this->setError('Falha ao atualizar dados');
         }
       }

       $categoria = $this->categoria->read('first','loja_categorias.id = '.$this->data['get']['id']);
       if(!empty($categoria)){
           $this->set('categoria',$categoria);
           $categorias_lista  = $this->categoria->getCategoriaTreeList();
           $categorias_lista[$categoria['parent_id']] = array($categorias_lista[$categoria['parent_id']],'selected');
           $this->set('categorias_lista',$categorias_lista);
       }else{
            $this->setError('Categoria não encontrada');
            $this->redirect($this->referer);
       }       
       $this->autoRender('/categorias/edit');
    }

    public function listar(){
        
        if(!isset($this->data['get']['page'])){
            $page = 1;
        }else{
            $page = $this->data['get']['page'];
        }
        $ofertas = $this->LojaOferta->paginate('*','loja_oferta.loja_categoria_id = '.$this->data['get']['id'],null,$this->limit,null,$page);
        $this->set('ofertas',$ofertas);
        $this->set('limit',$this->limit);
        
        $this->layout = 'front_end';
        $this->autoRender('/categorias/listar');
    }

 }
?>
