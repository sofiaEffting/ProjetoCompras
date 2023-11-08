<?php


class CadastroController
{
    public function index()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader, [
            'auto_reload' => true
        ]);
        $template = $twig->load('cadastro.html');

        return $template->render($_SESSION);
    }

    //checa se os dados passados no cadastro cumprem com o requisito
    public function check()
    {
        unset($_SESSION['msg']);

        $_POST['telefone']      = str_replace(['(', ')', '-'], '', $_POST['telefone']);
        $_POST['senha']         = md5($_POST['senha']);
        $_POST['nivel_acesso'] = 1;

        if ($_POST['nome_social'] == '')
            unset($_POST['nome_social']);
        if ($_POST['nome_substituto'] == '')
            unset($_POST['nome_substituto']);
        try {
            $cadastroRealizado = User::cadastrar($_POST);
            echo 'teste';
            $_SESSION['msg'] = 'Cadastro realizado com sucesso!';
        } catch (\Exception $e) {
            $_SESSION['msg'] = 'Houve um erro ao realizar o cadastro!' . $e->getMessage();
        }
        header('Location: ../cadastro/index');
    }

    public function viewAlterar()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader, [
            'auto_reload' => true
        ]);

        $template = $twig->load('atualizarCadastroUsuario.html');

        return $template->render($_SESSION);
    }        


    public function alterar(){
        unset($_SESSION['msg']);

        $_POST['telefone']      = str_replace(['(', ')', '-'], '', $_POST['telefone']);
        $_POST['senha']         = md5($_POST['senha']);
        $_POST['nivel_acesso'] = 1;

        if ($_POST['nome_social'] == '')
            unset($_POST['nome_social']);
        if ($_POST['nome_substituto'] == '')
            unset($_POST['nome_substituto']);
        try {
            $atualizacaoRealizado = User::atualizar($_POST);
            echo 'teste';
            $_SESSION['msg'] = 'Alteração realizada com sucesso!';
        } catch (\Exception $e) {
            $_SESSION['msg'] = 'Houve um erro ao realizar as alterações!' . $e->getMessage();
        }
        header('Location: ../cadastro/viewAlterar');

    }
 
    public function deletarConta($siape){
        unset($_SESSION['msg']);
        
        try{
            $deletaUsuario = User::deletarConta($siape);

            unset($_SESSION);
            session_destroy();
            header("location:../login");
        }catch(\Exception $e){
        }catch(\Exception $e) {
            $_SESSION['msg'] = 'Houve um erro ao deletar!' . $e->getMessage();
        }
        
    }


}
