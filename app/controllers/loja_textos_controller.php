<?php
class Loja_Textos extends controller{
    private $LojaTexto = null;
    private $limit = 15;

    public function __construct(){
        parent::__construct();
        $this->LojaTexto = new LojaTexto();
    }

    public function index(){
        if(!isset($this->data['get']['page'])){
            $page = 1;
        }else{
            $page = $this->data['get']['page'];
        }

        $textos = $this->LojaTexto->paginate('*',null,null,$this->limit,null,$page);
        $this->set('textos',$textos);
        $this->set('limit',$this->limit);
        
        $this->autoRender("/loja_textos/index");
    }

    public function edit(){

        if(!empty($this->data['post'])){
          $sql = "UPDATE loja_textos set local = '{$this->data['post']['local']}',
                                         texto = '{$this->data['post']['texto']}',
                                         ativo = '{$this->data['post']['ativo']}'
                  WHERE id = {$this->data['post']['id']}
                 "  ;

          if($this->LojaTexto->executeQuery($sql)){
              $this->setConfirm('Texto atualizado com sucesso');
          }else{
              $this->setError('Falha ao atualizar texto');
          }
          $this->redirect('/loja_textos/');
          exit();
        }

        $lojaTexto = $this->LojaTexto->read('first','id = '.$this->data['get']['id']);
        $this->set('lojaTexto',$lojaTexto);

        $this->autoRender("/loja_textos/edit");
    }


    public function ativar(){
        if(isset($this->data['get']['id']) && isset($this->data['get']['status'])){
            if($this->data['get']['status'] == 'status_ativo') $ativo = 0;
            if($this->data['get']['status'] == 'status_desativado') $ativo = 1;
            $sql = 'UPDATE loja_textos SET ativo = '.$ativo.' WHERE id = '.$this->data['get']['id'];

            if($this->LojaTexto->executeQuery($sql)){
               $this->setConfirm('Status modificado com sucesso!');
               $this->redirect($this->referer);
            }
        }
    }

    public function delete(){

        if($this->data['get']['id']){
            if($this->LojaTexto->update(array('texto'=>''),'id = '.$this->data['get']['id'])){
                $this->setConfirm('Texto apagado com sucesso.');
            }else{
                $this->setError('Falaha ao atualizar Texto');
            }
            $this->redirect($this->referer);
        }
    }

}
?>