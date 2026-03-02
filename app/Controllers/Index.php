<?php 

namespace App\Controllers;

use App\Models\EmpresaModel;
use App\Models\UsuarioModel;

class Index extends BaseController{

    private $empresaModel;
    private $usuarioModel;

    public function __construct(){
        $this->empresaModel = new \App\Models\EmpresaModel();
        $this->usuarioModel = new \App\Models\UsuarioModel();
    }
    
    public function index(): string {
        return view('index/index');
    }

    public function login(){
        return view('login/login');
    }

    //Método para logar 
    public function logar(){
        $usuario = $this->request->getPost('usuario');
        $senha = $this->request->getPost('senha');

        $usuarioModel = new UsuarioModel();
        $user = $usuarioModel->where('usuario', $usuario)->first();

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'mensagem' => 'Usuário não encontrado'
            ]);
        }

        if (!password_verify($senha, $user->senha)) {
            return $this->response->setJSON([
                'status' => 'error',
                'mensagem' => 'Senha inválida'
            ]);
        }

        // Login OK → cria sessão
        session()->set([
            'usuario_id'    => $user->id,
            'id_empresa'    => $user->id_empresa,
            'usuario_email' => $user->email,
            'usuario' => $user->usuario,
            'nome' => $user->nome,
            'sobrenome' => $user->sobrenome,
            'privilegio' => $user->privilegio,
            'logado'     => true,
        ]);
        return $this->response->setJSON([
            'status' => 'success',
            'mensagem' => 'Seja bem-vindo(a) ao Supremacy'
        ]);
    }

    //Metodo para deslogar
    public function logout(){
        session()->destroy();
        return redirect()->to('/login');
    }
    
    public function cadastre_se(): string{
        return view('login/cadastre_se');
    }

    //Funções para o Cadastro de Empresa

    //Tela de cadastro novo
    public function cadastre_empresa(): string{
        return view('login/cadastre_empresa');
    }

    //Função para Salvar o cadastro da Empresa
    public function salvar_empresa(){
        $data = $this->request->getPost();

        $empresaModel = new EmpresaModel();
        $usuarioModel = new UsuarioModel();

        // Dados da empresa
        $dataEmpresa = [
            'nome'     => $data['nome'],
            'cpf'      => $data['cpf'] ?: null,
            'cnpj'     => $data['cnpj'] ?: null,
            'telefone' => $data['telefone'] ?: null,
            'celular'  => $data['celular'] ?: null,
            'email'    => $data['email'],
            'admin'    => $data['admin'],
        ];

        // --- Usuário admin ---
        $partes = preg_split('/\s+/', trim($data['admin']));
        $nome = $partes[0];
        $sobrenome = count($partes) > 1 ? implode(' ', array_slice($partes, 1)) : '';

        $usuarioBase = strtolower(
            iconv('UTF-8', 'ASCII//TRANSLIT', implode('', $partes))
        );

        $usuarioFinal = $this->gerarUsuarioUnico($usuarioBase, $usuarioModel);

        // TRANSACTION
        $db = \Config\Database::connect();
        $db->transBegin();

        //Salvar empresa
        $idEmpresa = $empresaModel->insert($dataEmpresa, true);

        if ($idEmpresa  === false) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $empresaModel->errors()
            ]);
        }

        $idEmpresa = $empresaModel->getInsertID();
        log_message('debug', 'ID EMPRESA: ' . $idEmpresa);
        $senha = str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT); //Senha de 5 numeros aleatorios

        // INSERT usuário
        $dataUsuario = [
            'nome'        => $nome,
            'sobrenome'   => $sobrenome,
            'usuario'     => $usuarioFinal,
            'id_empresa'  => $idEmpresa,
            'email'       => $data['email'],
            'senha'       => $senha, // hash pela Entity
            'privilegio'  => 'admin',
        ];

        $retornoUsuario = $usuarioModel->insert($dataUsuario);

        if ($retornoUsuario === false) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $usuarioModel->errors()
            ]);
        }

        $db->transCommit();

        return $this->response->setJSON([
            'status' => 'success',
            'mensagem' => 'Empresa cadastrada com sucesso!',
            'usuario' => $usuarioFinal,
            'senha' => $senha
        ]);
    }

    public function esqueci_senha() {
        return view('login/esqueci_senha');
    }

    //Função para recuperar a senha do usuario
    public function recuperar_senha() {
       
        $email = $this->request->getPost('email');
        log_message('debug', 'Email enviado: ' . $email);

        $user = $this->usuarioModel->where('email', $email)->first();
         log_message('debug', 'Usuario: ' . $user->nome);

        // Sempre resposta genérica (segurança)
        if (!$user) {
            return $this->response->setJSON([
                'mensagem' =>  'Se o e-mail existir, enviaremos instruções.'
            ]);
        }

        $token = bin2hex(random_bytes(32));

        $this->usuarioModel->update($user->id, [
            'reset_token'   => $token,
            'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);

        $emailService = \Config\Services::email();

        $link = site_url("nova-senha/$token");

        $emailService->setTo($user->email);
        $emailService->setSubject('Recuperação de senha');
        $emailService->setMessage("
            <p>Olá, {$user->nome}</p>
            <p>Recebemos uma solicitação para redefinir sua senha.</p>
            <p>
                <a href='{$link}'>Clique aqui para criar uma nova senha</a>
            </p>
            <p>Este link expira em 1 hora.</p>
            <p>Se você não solicitou, ignore este e-mail.</p>
        ");

        if (!$emailService->send()) {
            log_message('error', $emailService->printDebugger(['headers']));
        }

         return $this->response->setJSON([
            'mensagem' =>  'Se o e-mail existir, enviaremos instruções.'
        ]);
    }

    //Abrir tela para criar nova senha através do link enviado por email
    public function novaSenha($token){
        $user = $this->usuarioModel->where('reset_token', $token)->where('reset_expires >=', date('Y-m-d H:i:s'))->first();

        //Se os dados não baterem...
        if (!$user) {
            return $this->response->setJSON([
                'mensagem' =>  'Link inválido ou expirado'
            ]);
        }

        return view('login/nova_senha', [
            'token' => $token
        ]);
    }

    //Cadastrar a nova senha
    public function salvarNovaSenha(){
        $token  = $this->request->getPost('token');
        $senha  = $this->request->getPost('senha');
        $confirma = $this->request->getPost('confirma');

        if ($senha !== $confirma) {
            return $this->response->setJSON([
                'status' => 'errorSenhas',
                'mensagem' =>  'As senhas não conferem'
            ]);
        }

        $user = $this->usuarioModel->where('reset_token', $token)->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'mensagem' =>  'Link inválido ou expirado'
            ]);
        }

        $this->usuarioModel->update($user->id, [
            'senha'         => $senha,
            'reset_token'   => null,
            'reset_expires' => null,
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'mensagem' =>  'Senha alterada com sucesso'
        ]);
    }

    //Função para gerar um usuário unico sempre
    private function gerarUsuarioUnico(string $baseUsuario, UsuarioModel $usuarioModel): string{
        $usuario = $baseUsuario;
        $i = 1;

        while ($usuarioModel->where('usuario', $usuario)->first()) {
            $usuario = $baseUsuario . $i;
            $i++;
        }
        return $usuario;
    }
}
?>