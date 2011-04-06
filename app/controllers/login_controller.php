<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login_controller
 *
 * @author Honjoya
 */
class Login extends Controller {
    //put your code here

    public function index(){
       $this->layout = 'ajax';
       $this->autoRender('/login/index');
    }

    public function entrar(){
        if(empty($this->data['post']['usuario']) || empty($this->data['post']['senha'])){
            echo 'Verifique os dados informados';
        }else{
            $Usuario = new Usuario();
            $usuario = $Usuario->read('first',"usuario = '{$this->data['post']['usuario']}' and senha = '{$this->data['post']['senha']}'");
            if(!empty($usuario['usuario']) && !empty($usuario['loja_grupo_id'])){
                $_SESSION['login'] = $usuario;
            }else{
                echo 'Usuário e senha não encontrado.';
            }
        }
    }

    public function logout(){
        unset($_SESSION['login']);
        $this->redirect('/login');
    }
}
?>
