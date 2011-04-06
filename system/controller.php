<?php
    class Controller extends System{

        private $_sets = array();
        public  $layout = 'default';
        public  $data = array();
        private $error = '';
        private $confirm = '';
        public  $referer = '';
        public  $flashMessage = '';

        public function __construct(){
            parent::__construct();
            $this->data['post'] = $_POST;
            $this->data['post'] = array_merge($this->data['post'],$_FILES);
            $this->data['get'] = $_GET;

            if(isset($_SESSION['error'])){
               $this->error = $_SESSION['error'];
               $this->flashMessage = $this->error;
            }
            if(isset($_SESSION['confirm'])){
               $this->confirm = $_SESSION['confirm'];
               $this->flashMessage = $this->confirm;
            }
            $_SESSION['confirm'] = $_SESSION['error'] = '';

            if(isset($_SERVER['HTTP_REFERER'])){
                $this->referer = $_SERVER['HTTP_REFERER'];
            }else{
                $this->referer = '/'.$this->_controller.'/'.$this->_action;
            }
        }

        protected function referer(){
            return '\'/'.$this->_controller.'/'.$this->_action.'\'';
        }

        public function setError($message){
            $this->error = '<div id=\'error_message\'>'.$message.'</div>';
            $this->flashMessage = $this->error;
        }

         public function setConfirm($message){
            $this->confirm = '<div id=\'confirm_message\'>'.$message.'</div>';
            $this->flashMessage = $this->confirm;
        }

        public function set($nome , $valor){
            if($nome && $valor){
                $this->_sets[] = array($nome=>$valor);
            }
        }

        function redirect($patch){
          $_SESSION['error'] = $this->error;
          $_SESSION['confirm'] = $this->confirm;
          
          header("Location:$patch");
        }

        protected function element($element,$vars = array()){
            if(!empty($element)){
                $file = ELEMENT .$element. '.phtml';
                if(!file_exists($file)){
                    die('element not found!');
                }else{
                    if(is_array($vars)){
                        extract($vars);
                    }
                    require_once($file);
                }
            }else{
                die('element not valid!');
            }



        }

        protected function autoRender( $phtmlView ){

            foreach($this->_sets as $set){
                if( is_array($set) && count($set) > 0 )
                    extract ($set);
            }

            $layout = LAYOUT.$this->layout.'.phtml';
            $file = VIEWS .$phtmlView. '.phtml';
            
                if ( !file_exists($layout) )
                    die("Layout definido não existe");

                if ( !file_exists($file) )
                    die("Houve um erro. View nao existe.");
             
             $require_for_layout = $file;
             require_once($layout);
        }
    }
?>