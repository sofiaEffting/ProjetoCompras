<?php



class LoginController
{
    public function index()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true
        ]);

        $template = $twig->load('login.html');

        return $template->render();
    }

    public function check(){
        $siape = $_POST['siape'];
        $senha = md5($_POST['senha']);

        try{
            $user = new User;
            $user->setSiape($siape);
            $user->setSenha($senha);
            $user->validateLogin();

            header('Location: ../view/paginaprincipaladm.html');

        }catch(\Exception $e){

            header('Location: ../index.php');
            
        }
    }
}