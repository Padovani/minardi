<?php
class Marcas extends Controller{
    public  $Marca = null;
    private $limit = 10;

    public function  __construct() {
        parent::__construct();
        $this->Marca = new Marca();
    }

    public function index(){

        if(!isset($this->data['get']['page'])){
            $page = 1;
        }else{
            $page = $this->data['get']['page'];
        }
        $marcas = $this->Marca->paginate('*',null,null,$this->limit,null,$page);

        $this->set('marcas',$marcas);
        $this->set('limit',$this->limit);
        $this->autoRender('/marcas/index');
    }

    public function add(){
        if(!empty($this->data['post'])){
            $ImagemHelper = new ImagemHelper();
           if($ImagemHelper->checkImage($this->data['post']['imagem'])){
               if(isset($this->data['post']['nome'])){
                   $sql = "INSERT INTO loja_marcas (nome,imagem,site,ativo) VALUES('{$this->data['post']['nome']}','{$ImagemHelper->tipo}','{$this->data['post']['site']}','{$this->data['post']['ativo']}')";
                   if($this->Marca->executeQuery($sql)){
                     $this->setConfirm('Marca cadastrada com sucesso.');
                      if($ImagemHelper->saveImage($this->data['post']['imagem'],$this->Marca->id,'webroot/img/loja_marcas')){
                          $this->setConfirm('Marca e imagem cadastrada com sucesso.');
                      }
                   }else{
                       $this->setConfirm('Falha ao cadastrar marca.');
                   }
               }
           }
        }
        $this->autoRender('/marcas/add');
    }


    /**
     * @todo Fazer ediçao sem a necessidade de postar imagem
     */
    public function edit(){
        if(!empty($this->data['post'])){
            $ImagemHelper = new ImagemHelper();
            if($this->data['post']['imagem']['error'] == 0 && $ImagemHelper->checkImage($this->data['post']['imagem'])){
                if($ImagemHelper->saveImage($this->data['post']['imagem'],$this->data['post']['id'],'webroot/img/loja_marcas')){
                    $this->setConfirm('Marca e imagem modificada com sucesso.');
                }else{
                    $this->setConfirm('Marca modificada com sucesso.');
                }
            }

            $imagem = '';
            if(!empty($ImagemHelper->tipo)) $imagem =  ",imagem = '{$ImagemHelper->tipo}'";
            $sql = "UPDATE loja_marcas SET nome = '{$this->data['post']['nome']}', site = '{$this->data['post']['site']}' $imagem WHERE id =  {$this->data['post']['id']} ";
            if(!$this->Marca->executeQuery($sql)){
                 $this->setError('Falha ao concluir alteraçao');
                 $this->redirect('/marcas/');
            }else{
               $this->setError('Tipo de imagem inválida');
               $this->redirect('/marcas/');
            }
            $this->redirect('/marcas/');
        }
        $marca = $this->Marca->read('first','id = '.$this->data['get']['id']);
        $this->set('marca',$marca);
        $this->autoRender('/marcas/edit');
    }

    public function delete(){
        if($this->Marca->delete('id = '.$this->data['get']['id'])){
            $this->setConfirm('Marca deletada com sucesso');
        }else{
            $this->setError('Erro ao excluir imagem');
        }
        $this->redirect('/marcas/index');
    }

}
?>
