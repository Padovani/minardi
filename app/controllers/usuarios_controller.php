<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarios_controller
 *
 * @author Honjoya
 */
class Usuarios extends Controller {

    private $Usuario = null;
    private $limit = 12;
    

    public function  __construct() {
        parent::__construct();
        if($this->Usuario == null){
            $this->Usuario = new Usuario();
        }
    }

    public function index(){

        if(!isset($this->data['get']['page'])){
            $page = 1;
        }else{
            $page = $this->data['get']['page'];
        }

        $union = 'INNER JOIN loja_usuario_grupos ON(loja_usuarios.loja_grupo_id = loja_usuario_grupos.id)';
        $fields = 'loja_usuarios.*, loja_usuario_grupos.grupo';
        $usuarios = $this->Usuario->paginate($fields,null,$union,$this->limit,'loja_usuarios.id',$page);

        $this->set('usuarios',$usuarios);
        $this->set('limit',$this->limit);
        $this->autoRender('/usuarios/index');
    }

    public function add(){

        if(isset($this->data['post']) && !empty($this->data['post'])){
            if(!empty($this->data['post']['loja_grupo_id'])) $grupo   = $this->data['post']['loja_grupo_id']; else $erro = 1;
            if(!empty($this->data['post']['usuario']))       $usuario = $this->data['post']['usuario']; else $erro = 1;
            if(!empty($this->data['post']['nome_completo'])) $nome_c  = $this->data['post']['nome_completo']; else $erro = 1;
            if(!empty($this->data['post']['senha'])) $senha   = $this->data['post']['senha']; else $erro = 1;
            if(!empty($this->data['post']['ativo'])) $ativo   = $this->data['post']['ativo']; else $erro = 1;

            if(isset($erro)){
                $this->setError("Campos necessários não informado");
            }else{
                $sql = "INSERT INTO loja_usuarios(loja_grupo_id,usuario,nome_completo,senha,ativo)
                        VALUES ('{$grupo}','{$usuario}','".utf8_decode($nome_c)."','{$senha}','{$ativo}')";

                if($this->Usuario->executeQuery($sql)){
                    echo "<div id='confirm_message'>Usuario cadastrado com sucesso.</div>";
                }else{
                    echo "<div id='error_message'>Falha ao cadastrar usuário.</div>";
                }
            }
        }else{

            $Grupo = new Grupo();
            $grupo_lista =  $Grupo->getGrupos();
            $this->set('grupo_lista',$grupo_lista);

            $this->autoRender('/usuarios/add');
        }
    }

    public function ativar(){
        if(isset($this->data['get']['id']) && !empty($this->data['get']['id']) && isset($this->data['get']['status']) && !empty($this->data['get']['status'])){
            if($this->data['get']['status'] == 'status_ativo') $ativo = 0;
            if($this->data['get']['status'] == 'status_desativado') $ativo = 1;
            $sql = 'UPDATE loja_usuarios SET ativo = '.$ativo.' WHERE id = '.$this->data['get']['id'];

            if($this->Usuario->executeQuery($sql)){
               $this->setConfirm('Status altedado com sucesso!');
               $this->redirect($this->referer);
            }
        }
    }

    public function edit(){
        if(isset($this->data['post']) && !empty($this->data['post'])){
            $sql = 'UPDATE loja_usuarios set loja_grupo_id = \''.$this->data['post']['loja_grupo_id']. '\', usuario = \''.$this->data['post']['usuario'].'\',
                    nome_completo = \''.$this->data['post']['nome_completo'].'\',
                    ativo = \''.$this->data['post']['ativo'].'\' where loja_usuarios.id = '.$this->data['post']['id'];

            if($this->Usuario->executeQuery($sql)){
                $this->setConfirm('Usuário Alterado com sucesso.');
                $this->redirect($this->referer);
            }else{
                $this->setError('Falha ao atualizar dados');
                $this->redirect($this->referer);
            }
        }

        if(isset($this->data['get']['id']) && !empty($this->data['get']['id']) && empty($this->data['post'])){
            $usuario = $this->Usuario->read('first','loja_usuarios.id = '.$this->data['get']['id']);
            if(!empty($usuario)){
                $this->set('usuario',$usuario);
            }else{
                $this->setError('Usuario não encontrado');
                $this->redirect('/usuarios/index');
            }

            $Grupo = new Grupo();
            $grupo_lista =  $Grupo->getGrupos();

            if(isset($this->data['get']['id'])){
                foreach($grupo_lista as $k => $grupo){
                    if($grupo['id'] == $usuario['loja_grupo_id']){
                        $grupo_lista[$k]['selected'] = true;
                    }
                }
            }

            $this->set('grupo_lista',$grupo_lista);
            $this->autoRender('/usuarios/edit');
        }
    }

    public function delete(){
        if(isset($this->data['get']['id']) && !empty($this->data['get']['id'])){
            if($this->Usuario->delete($this->data['get']['id'])){
                $this->setConfirm('Usuario Exlcuido com sucesso.');
                $this->redirect($this->referer);
            }else{
                $this->setError('Usuario Exlcuido com sucesso.');
                $this->redirect($this->referer);
            }
        }
    }
}
?>
