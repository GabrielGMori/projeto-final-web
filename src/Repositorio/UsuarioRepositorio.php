<?php
require_once __DIR__ . '/../Modelo/Usuario.php';

class UsuarioRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Usuario
    {
        return new Usuario((int)$dados['id_pk'], $dados['email'], $dados['senha'], $dados['permissao']);
    }

    public function listar(): array
    {
        $sql = "SELECT id_pk, email, senha, permissao FROM usuario ORDER BY email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        $dadosFormatados = array();
        for ($i = 0; $i < count($dados); $i++) {
            $dadosFormatados[$i] = $this->formarObjeto($dados[$i]);
        }
        return $dadosFormatados;
    }

    public function criar(string $email, string $senha, string $permissao): void
    {
        $sql = "INSERT INTO usuario(email, senha, permissao) VALUES (?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->bindValue(2, password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(3, $permissao);
        $stmt->execute();
    }

    public function buscarPorEmail(string $email): ?Usuario
    {
        $sql = "SELECT id_pk, email, senha, permissao FROM usuario WHERE email = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function autenticar(string $email, string $senha): bool
    {
        $usuario = $this->buscarPorEmail($email);
        return $usuario ? password_verify($senha, $usuario->getSenha()) : false;
    }
}
