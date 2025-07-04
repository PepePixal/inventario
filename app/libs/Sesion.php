<?php
class Sesion
{
    private $login = false;
    private $usuario;

    function __construct()
    {
        //inicia la session
        session_start();
        //valida si el 'usuario' esta en la sper glob $_SESSION y no es NULL
        if(isset($_SESSION['usuario'])) {
            //obtiene el usuario de la $_SESSION
            $this->usuario = $_SESSION['usuario'];
            //activa banderita login true
            $this->login = true;
        
        //si usuario no esta en $_SESSION
        } else {
            //borra el valor de usuario
            unset($this->usuario);
            //desactiva banderita login
            $this->login = false;
        }
    }

    public function iniciarLogin($usuario = '')
    {
        //valida si hay usuario
        if ($usuario) {
            //asigna el $usuario recibido al usuario de la $_SESSION iniciada y al atributo usuario
            $this->usuario = $_SESSION['usuario'] = $usuario;
            //activa banderita login
            $this->login = true;
        }
    }

    public function finalizarLogin()
    {
        //elimina los valores 
        unset($this->usuario);
        unset($_SESSION['usuario']);
        //desactiva banderita login
        $this->login = false;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }
}
?>