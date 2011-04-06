<?php
class loja_imagem extends Controller{
    public $LojaImagem = null;

    public function  __construct() {
        parent::__construct();
        if($this->LojaImagem == null){
            $this->LojaImagem =  new LojaImagem();
        }
    }

    public function index(){

        $imagens = $this->LojaImagem->read();
        $this->set('imagens',$imagens);
        $this->autoRender('/loja_imagem/index');
    }


    public function edit(){
        if(!empty($this->data['post'])){
            $ImageHelper = new ImagemHelper();
            if($ImageHelper->checkImage($this->data['post']['imagem'])){
                if($ImageHelper->saveImage($this->data['post']['imagem'],$this->data['post']['id'],'webroot/img/loja_imagem')){
                    $this->LojaImagem->executeQuery('UPDATE loja_imagens SET imagem = \''.$ImageHelper->tipo.'\' WHERE id = '.$this->data['post']['id']);
                    $this->setConfirm('Nova imagem cadastrada com sucesso');
                }else{
                    $this->setError('Falha ao cadastrar nova imagem, tente novamente.');
                }
                $this->redirect('/loja_imagem/index');
            }
        }else{
            $this->layout = 'ajax';
            $id = $this->data['get']['id'];
            $image = $this->LojaImagem->read('first','loja_imagens.id = '. $id);
            $this->set('image',$image);
            $this->autoRender('/loja_imagem/edit');
        }

    }

    public function delete(){
        if($this->data['get']['id']){
            $imagem = $this->LojaImagem->read('first','id = '.$this->data['get']['id']);
            if(!empty($imagem['imagem'])){
                $sql = 'UPDATE loja_imagens SET imagem = null WHERE id = '.$this->data['get']['id'];
                if($this->LojaImagem->executeQuery($sql)){
                    $ImageHelper = new ImagemHelper();
                    $ImageHelper->deleteImage('webroot/img/loja_imagem/'.$imagem['id'].'.'.$imagem['imagem']);
                    $this->setConfirm('Imagem Excluida com sucesso.');
                    $this->redirect('/loja_imagem/index');
                }
            }else{
                $this->setError('Imagem já excluida');
                $this->redirect('/loja_imagem/index');
            }
        }else{
            $this->setError('Identificado inválido');
            $this->redirect('/loja_imagem/index');
        }
    }


}
?>
