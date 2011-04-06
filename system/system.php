<?php
    function debug($conteudo){
        if(!empty($conteudo)){
            echo "<pre>";print_r($conteudo); echo "</pre>";
        }else{
            echo "<pre>";print_r(array()); echo "</pre>";
        }
    }

    class System{
        private $_url;
        private $_explode;
        public $_controller;
        public $_action;
        public $_params;

        


        public function  __construct(){
            $this->setUrl();
            $this->setExplode();
            $this->setController();
            $this->setAction();
            $this->setParams();
        }


        private function setUrl(){
            $_GET['url'] = (isset($_GET['url']) ? $_GET['url'] : 'index/index');
            $this->_url = $_GET['url'] .'/' ;
        }

        private function setExplode(){
            $this->_explode = explode( '/' , $this->_url );
        }

        private function setController(){
            $this->_controller = $this->_explode[0];
        }
        
        private function setAction(){
            $ac = (!isset($this->_explode[1]) || $this->_explode[1] == null || $this->_explode[1] == 'index' ? 'index' : $this->_explode[1]);
            $this->_action = $ac;
        }

        private function setParams(){
            unset( $this->_explode[0], $this->_explode[1] );
            array_pop( $this->_explode );

            if ( end( $this->_explode ) == null )
                array_pop( $this->_explode );

            $i = 0;
            if( !empty ($this->_explode) ){
                foreach ( $this->_explode as $val ){
                    if ( $i % 2 == 0 ){
                        $ind[] = $val;
                    }else{
                        $value[] = $val;
                    }
                    $i++;
                }
            }else{
                $ind = array();
                $value = array();
            }
            if( count($ind) == count($value) && !empty($ind) && !empty($value) )
                $this->_params = array_combine($ind, $value);
            else
                $this->_params = array();
        }

        public function getParam( $name = null ){
            if ( $name != null )
                return $this->_params[$name];
            else
                return $this->_params;
        }

        public function run(){

            session_start();
            #Realiza a validação .

            require_once('acesscontrol.php');
            AcessControl::verificaAcesso($this->_controller,$this->_action);
            
            $controller_path = CONTROLLERS . $this->_controller . '_controller.php';
            if( !file_exists( $controller_path ) )
                die('Houve um erro. O controller nao existe.');

            require_once( $controller_path );
            $app = new $this->_controller();

                if( !method_exists($app, $this->_action) )
                    die('Esta action nao existe.');

            $action = $this->_action;
            $app->$action();
        }
    }
?>