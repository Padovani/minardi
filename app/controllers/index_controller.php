<?php
class Index extends controller{
    private $LojaCategoria;
    private $LojaOferta;
    
    public function index(){

        $this->LojaCategoria = new Categoria();
        $this->set('categorias', $this->LojaCategoria->categoriaMenu());
        $this->LojaOferta = new LojaOferta();
        $sql = 'SELECT loja_oferta.*, loja_oferta_imagens.id as id_imagem,loja_oferta_imagens.imagem FROM loja_oferta LEFT JOIN loja_oferta_imagens ON(loja_oferta_imagens.loja_oferta_id = loja_oferta.id) LIMIT 15';
        $this->set('ofertas',$this->LojaOferta->executeQuery($sql));

        $this->layout = 'front_end';
        $this->autoRender('index/index');
    }
}
?>
