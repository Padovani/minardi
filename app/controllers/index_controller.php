<?php
class Index extends controller{

    public function index(){
        $this->set('title_for_layout','Loja do Z�');
        $this->layout = 'front_end';

        $this->autoRender('index/index');
    }

}
?>
