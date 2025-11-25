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

    public function listarPaginado(int $limite, int $offset): array
    {
        $sql = "SELECT id_pk, email, senha, permissao FROM usuario ORDER BY email LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limite, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        $dadosFormatados = array();
        for ($i = 0; $i < count($dados); $i++) {
            $dadosFormatados[$i] = $this->formarObjeto($dados[$i]);
        }
        return $dadosFormatados;
    }

    public function remover(int $id): void
    {
        $sql = "DELETE FROM usuario WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function editar(Usuario $usuario): void
    {
        $sql = "UPDATE usuario SET email = ?, senha = ?, permissao = ? WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $usuario->getEmail());
        $stmt->bindValue(2, password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stmt->bindValue(3, $usuario->getPermissao());
        $stmt->bindValue(4, $usuario->getId());
        $stmt->execute();
    }

    public function buscarPorId(int $id): ?Usuario
    {
        $sql = "SELECT id_pk, email, senha, permissao FROM usuario WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function contar(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM usuario";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $dados['total'];
    }
}
