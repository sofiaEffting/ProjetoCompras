<?php


class CadastroController
{
    public function index()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true
        ]);
        $template = $twig->load('cadastro.html');

        return $template->render();
    }

    public function check(){
        $setor = $_POST['setor'];
        $nome = $_POST['nome'];
        $siape = $_POST['siape'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $senha = md5($_POST['senha']);
        $nivelDeAcesso = 2;
        $nomesocial = $_POST['nomesocial']; 

        try{
            $user = new User;
            $user->setEmail($email);
            $user->setnome($nome);
            $user->setNivelAcesso($nivelDeAcesso);
            $user->setSenha($senha);
            $user->setSiape($siape);
            $user->setTelefone($telefone);
            $user->setSetor($setor);
            $user->cadastrar();
            $user->validateLogin();
        }catch(\Exception $e){
            header('Location: ../index.php');
        }
    }
}