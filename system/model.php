<?php
    class Model{
        public static $_db;
        public $_tabela;
        private $_result;
        private $_limit = 15;
        public $id = null;
        
        public function  __construct(){
            if(self::$_db == null){
                self::$_db = mysql_connect(Config::$server,Config::$user,Config::$password);
                mysql_select_db(Config::$data_base);
            }
        }


        private function reset(){
            $this->_result = array();
        }

        public function insert( Array $dados ){
            $this->reset();
            $campos = implode(", ", array_keys($dados));
            $valores = "'".implode("','", array_values($dados))."'";
            return $this->query(" INSERT INTO `{$this->_tabela}` ({$campos}) VALUES ({$valores}) ");
        }

      
        public function read($type = null,$where = null, $limit = null, $offset = null, $orderby = null ){
            $this->reset();

            if($type === 'first') $limit = 1;

            $this->_result = array();

            $where = ($where != null ? "WHERE {$where}" : "");
            $limit = ($limit != null ? "LIMIT {$limit}" : "");
            $offset = ($offset != null ? "OFFSET {$offset}" : "");
            $orderby = ($orderby != null ? "ORDER BY {$orderby}" : "");
            try{
                $q = mysql_query(" SELECT * FROM `{$this->_tabela}` {$where} {$orderby} {$limit} {$offset} ");
            }catch(Exception $e){
                die($e);
            }

            $this->mysqlToArray($q);
            
            if($type == 'first' && isset($this->_result[0])){
                return $this->_result[0];
            }else{
                return $this->_result;
            }
        }

        /**
         *@todo Faltar terminar de imprementar
         */
         public function paginate($fields = '*',$where = null, $union = null ,$limit = null, $orderby = null, $page = 1 ){
            $this->reset();
            
             if($limit != null){
                 $this->_limit = $limit;
             }

             if($page == 1){
                 $limit = '0,'.$this->_limit;
             }else{
                $page = ($page * $this->_limit) - $this->_limit;
                $limit = $page.','.$this->_limit;
             }

            $this->_result = array();

            $where = ($where != null ? "WHERE {$where}" : "");
            $limit = ($limit != null ? "LIMIT {$limit}" : "");
            $orderby = ($orderby != null ? "ORDER BY {$orderby}" : "");

            $q = mysql_query(" SELECT {$fields} FROM `{$this->_tabela}` {$union} {$where} {$orderby} {$limit} ");
            
            $paginate = $this->mysqlToArray($q);
            $paginate['total_found'] = $this->count();

            return $paginate;

        }

        public function count($where = null){
            $this->reset();

            $this->_result = array();

            $where = ($where != null ? "WHERE {$where}" : "");

            $q = mysql_query(" SELECT count(*) as count FROM `{$this->_tabela}` {$where} ");
            $this->mysqlToArray($q);
            
            if(isset($this->_result[0]['count'])) return $this->_result[0]['count']; else return 0;
        }

        public function update( Array $dados, $where ){
            $this->reset();
            foreach ( $dados as $ind => $val ){
                $campos[] = "{$ind} = '{$val}'";
            }
            $campos = implode(", ", $campos);
            return mysql_query(" UPDATE `{$this->_tabela}` SET {$campos} WHERE {$where} ");
        }

        public function delete( $id ){
            $this->reset();
            return mysql_query(" DELETE FROM `{$this->_tabela}` WHERE id = {$id} ");
        }

        public function executeQuery( $sql ){

            $result = array();
            try{
            $result =  mysql_query($sql) or die('problema na query: ' . mysql_error());;
            }catch(Exception $e){
                echo $e;
            }

            $this->id = $this->read('first',null,null,null,'id DESC');
            $this->reset();
            
            if(isset($this->id['id'])){
                $this->id =  $this->id['id'];
            }else{
                $this->id = null;
            }
            
            if($result === false){
                return false;
            }else if($result === true){
                return true;
            }else{
                return $this->mysqlToArray($result);
            }
        }

        private function mysqlToArray($q){
            
            if($q === false){
                return $this->_result;
            }
            while($array = mysql_fetch_array($q,MYSQL_ASSOC)){
                  $this->_result[] = $array;
            }
            
            return $this->_result;
        }

    public function generateTreeList($id = null,$separador = '---'){

        $this->reset();
        $this->_result = array();

            if($id){
                    $sql = "select * from ".$this->_tabela." where id = $id ";
            }else{
                    $sql = "select * from ".$this->_tabela." where parent_id is null OR parent_id = 0";
            }

            $res = mysql_query($sql);
            $resultado_array = array();

            if($res){
                    while($resultado = mysql_fetch_array($res,MYSQL_ASSOC)){
                            $resultado_array[$resultado['id']] = $resultado['nome'];
                    }
            }

            foreach($resultado_array as $k => $result){
                    $this->_result[$k] = $result;
                    $this->getFilha($k,$separador);
            }

            return $this->_result;
        }


        public  function getFilha($id,$separador){

        $sql = 'select * from '.$this->_tabela.' where parent_id = '.$id;
        $filhas = array();

        $res = mysql_query($sql);

                if($res){
                        while($resultado = mysql_fetch_array($res,MYSQL_ASSOC)){
                                $filhas[$resultado['id']] = $separador.' '.$resultado['nome'];
                        }
                }else{
                        return;
                }

                        foreach($filhas as $k=>$result){
                                $this->_result[$k] = $result;
                                $this->getFilha($k,$separador.$separador);
                }

                return $filhas;
        }
    }
?>
