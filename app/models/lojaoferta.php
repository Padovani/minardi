<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lojaoferta
 *
 * @author Honjoya
 */
class LojaOferta extends Model {
    public $_tabela = 'loja_oferta';
    private $_id;
    private $titulo;
    private $descricao;
    private $descricao_longa;
    private $tags;
    private $loja_categoria_id;
    private $loja_marca_id;
    private $preco;
    private $quantidade = 0;
    private $frete = 0;
    private $destaque = 0;
    private $parcela;
    private $juros;
    private $desconto;
    private $ativo;
    private $created;
    private $modified;

    public function __construct(){
        parent::__construct();
        $this->created = Date('Y-m-d');
        $this->modified = Date('Y-m-d');
    }

    public function setId($id){
        if(is_int($id)){
            $this->_id = $id;
        }
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setDescricao_longa($descricao_longa) {
        
        $this->descricao_longa = $descricao_longa;
    }

    public function setLoja_categoria_id($loja_categoria_id) {
        $this->loja_categoria_id = $loja_categoria_id;
    }

    public function setLoja_marca_id($loja_marca_id) {
        $this->loja_marca_id = $loja_marca_id;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function setQuantidade($quantidade = null){
        if($quantidade){
            $this->quantidade = $quantidade;
        }
    }

    public function setParcela($parcela) {
        $this->parcela = $parcela;
    }

    public function setJuros($juros) {
        $this->juros = $juros;
    }

    public function setDesconto($desconto) {
        $this->desconto = $desconto;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setTags($tags){
        $this->tags = $tags;
    }


    public function gravar(){
        $sql = "INSERT INTO $this->_tabela (id, titulo, descricao,descricao_longa,tags,loja_categoria_id ,loja_marca_id ,preço, quantidade, frete,destaque_home,parcela,juros,desconto,ativo,created,modified)
                VALUES (null,'{$this->titulo}', '{$this->descricao}',
        '{$this->descricao_longa}','{$this->tags}', '{$this->loja_categoria_id}', '{$this->loja_marca_id}','{$this->preco}',
        '{$this->quantidade}','{$this->frete}', '{$this->destaque}',
        '{$this->parcela}','{$this->juros}', '{$this->desconto}','{$this->ativo}', '{$this->created}', '{$this->modified}')";

        return $this->executeQuery($sql);
    }
}
?>
