<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loja_ofertas
 *
 * @author Honjoya
 */
class loja_ofertas extends Controller {
    private $LojaOferta = null;
    private $LojaOfertaImagem = null;
    private $limit = 10;
    
    public function __construct(){
        parent::__construct();
        if($this->LojaOferta === null){
            $this->LojaOferta = new LojaOferta();
        }

        if($this->LojaOfertaImagem === null){
            $this->LojaOfertaImagem = new lojaofertaimagem();
        }
    }

    public function add(){

        if(!empty($this->data['post'])){
            if($this->gravaProdutoAndImagem($this->data['post'])){
                $this->redirect('/loja_ofertas/');
            }else{
                $this->redirect($this->referer);
            }
            
        }

        $Categoria = new Categoria();
        $categorias = $Categoria->getCategoriaTreeList();
        $Marca = new Marca();
        $marcas = $Marca->read();
        $this->set('marcas',$marcas);
        $this->set('categorias',$categorias);
        $this->autoRender('loja_ofertas/add');
    }

    private function gravaProdutoAndImagem($produto){

        $this->LojaOferta->setLoja_categoria_id($produto['loja_categoria_id']);
        $this->LojaOferta->setLoja_marca_id($produto['loja_marca_id']);
        $this->LojaOferta->setTitulo($produto['titulo']);
        $this->LojaOferta->setDescricao($produto['descricao']);
        $this->LojaOferta->setDescricao_longa($produto['descricao_longa']);
        $this->LojaOferta->setPreco($produto['preco']);
        $this->LojaOferta->setQuantidade($produto['quantidade']);
        $this->LojaOferta->setParcela($produto['parcela']);
        $this->LojaOferta->setJuros($produto['juros']);
        $this->LojaOferta->setDesconto($produto['desconto']);
        $this->LojaOferta->setAtivo($produto['ativo']);
        $this->LojaOferta->setTags($produto['tags']);

        if($this->LojaOferta->gravar()){
            if($this->setGravaImagem($produto['imagem'],$this->LojaOferta->id)){
                $this->setConfirm("Produto cadastrado com sucesso");
                return true;
            }else{
                $this->setConfirm("Produto cadastrado, erro ao grava imagem");
                return true;
            }
        }else{
            $this->setError("Falha ao cadastrar produto");
            return false;
        }

    }

    private function setGravaImagem($imagem,$id){
       
       if($imagem['error'] > 0){
           return true;
       }

       $caminho = '/webroot/img/loja_ofertas/';
       $ImagemHelper = new ImagemHelper();
       if($ImagemHelper->checkImage($imagem)){
            $sql = "INSERT INTO loja_oferta_imagens (imagem,loja_oferta_id) VALUES('{$ImagemHelper->tipo}',$id)";
            $this->LojaOfertaImagem->executeQuery($sql);
            if($ImagemHelper->saveImage($imagem,$this->LojaOfertaImagem->id,$caminho,null,200)){
                 return true;
            }else{
                return false;
            }
       }else{
           return false;
       }
    }

    public function ativar(){
        if(isset($this->data['get']['id']) && isset($this->data['get']['status'])){
            if($this->data['get']['status'] == 'status_ativo') $ativo = 0;
            if($this->data['get']['status'] == 'status_desativado') $ativo = 1;
            $sql = 'UPDATE loja_oferta SET ativo = '.$ativo.' WHERE id = '.$this->data['get']['id'];

            if($this->LojaOferta->executeQuery($sql)){
               $this->setConfirm('Status modificado com sucesso!');
               $this->redirect($this->referer);
            }
        }
    }

    public function index(){
        if(!isset($this->data['get']['page'])){
            $page = 1;
        }else{
            $page = $this->data['get']['page'];
        }
        
        $ofertas = $this->LojaOferta->paginate('*',null,null,$this->limit,null,$page);
        $this->set('ofertas',$ofertas);
        $this->set('limit',$this->limit);
        $this->autoRender('/loja_ofertas/index');
    }

    public function delete(){
        $sql = 'SELECT loja_oferta_imagens.* FROM loja_oferta
                   INNER JOIN loja_oferta_imagens ON(loja_oferta_imagens.loja_oferta_id = loja_oferta.id)
                   WHERE loja_oferta.id = '.$this->data['get']['id'];
        
        $imagem = $this->LojaOferta->executeQuery($sql);
        if($this->LojaOferta->delete($this->data['get']['id'])){
            $this->setConfirm('Produto apagado com sucesso');
        }else{
                $this->setError('Falha ao apagar produto');
         }

        if(isset($imagem[0]['imagem'])){
            $this->deleteImagem($imagem[0]['id'],$imagem[0]['imagem']);
        }

        $this->redirect($this->referer);
    }

    private function deleteImagem($id,$tipo){

        $this->LojaOfertaImagem->delete($id);

        $imagem = '/webroot/img/loja_ofertas/'.$id . '.' . $tipo;
        $ImagemHelper = new ImagemHelper();
        $ImagemHelper->deleteImage($imagem);

    }

    public function edit(){

       if(!empty($this->data['post'])){
            if($this->updateLojaOferta($this->data['post'])){
                $this->setConfirm('Alteração gravada com sucesso');
                $this->redirect('/loja_ofertas');
            }else{
                $this->setError('Problemas ao gravar alterações');
                $this->redirect($this->referer);
            }
       }

        if(isset($this->data['get']['id'])){
            $id = $this->data['get']['id'];
            $sql = 'SELECT loja_oferta.*, loja_oferta_imagens.id as id_imagem, loja_oferta_imagens.imagem  FROM loja_oferta LEFT JOIN loja_oferta_imagens ON(loja_oferta_imagens.loja_oferta_id = loja_oferta.id) WHERE loja_oferta.id = '. $id;
            $lojaOferta = $this->LojaOferta->executeQuery($sql);

            if(!empty($lojaOferta)){
                $Categoria = new Categoria();
                $categorias = $Categoria->getCategoriaTreeList();
                $Marca = new Marca();
                $marcas = $Marca->read();
                $this->set('marcas',$marcas);
                $this->set('categorias',$categorias);
                $this->set('lojaOferta',$lojaOferta);
            }else{
                $this->setError('Produto não encontrado');
                $this->redirect($this->referer);
            }
        }else{
            $this->setError('identificador invalido');
            $this->redirect($this->referer);
        }

        $this->autoRender('loja_ofertas/edit');
    }

    private function updateLojaOferta($lojaOferta){

        if(!empty($lojaOferta['imagem_atual_id']) && $lojaOferta['imagem']['error'] == 0){
            $this->deleteImagem($lojaOferta['imagem_atual_id'],$lojaOferta['imagem_atual_formato']);
        }

        if(isset($lojaOferta['imagem']) && $lojaOferta['imagem']['error'] == 0){
            $this->setGravaImagem($lojaOferta['imagem'], $lojaOferta['id']);
        }


        $sql = "UPDATE loja_oferta SET 
                    titulo            = '{$lojaOferta['titulo']}',
                    descricao         = '{$lojaOferta['descricao']}',
                    descricao_longa   = '{$lojaOferta['descricao_longa']}',
                    tags              = '{$lojaOferta['tags']}',
                    loja_categoria_id = '{$lojaOferta['loja_categoria_id']}',
                    loja_marca_id     = '{$lojaOferta['loja_marca_id']}',
                    quantidade        = '{$lojaOferta['quantidade']}',
                    preço             = '{$lojaOferta['preco']}',
                    parcela           = '{$lojaOferta['parcela']}',
                    juros             = '{$lojaOferta['juros']}',
                    desconto          = '{$lojaOferta['ativo']}',
                    modified          = '".Date('Y-m-d')."'
                WHERE id = {$lojaOferta['id']}
                ";

         if($this->LojaOferta->executeQuery($sql)){
            return true;
         }else{
            return false;
         }
         
    }
}
?>
