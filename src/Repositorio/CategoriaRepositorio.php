<?php
require_once __DIR__ . '/../Modelo/Categoria.php';

class CategoriaRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Categoria
    {
        return new Categoria((int)$dados['id_pk'], $dados['nome']);
    }

    public function listar(): array
    {
        $sql = "SELECT id_pk, nome FROM categoria ORDER BY nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        $dadosFormatados = array();
        for ($i = 0; $i < count($dados); $i++) {
            $dadosFormatados[$i] = $this->formarObjeto($dados[$i]);
        }
        return $dadosFormatados;
    }

    public function criar(string $nome): void
    {
        $sql = "INSERT INTO categoria(nome) VALUES (?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $nome);
        $stmt->execute();
    }

    public function remover(int $id): void
    {
        $sql = "DELETE FROM categoria WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public function editar(Categoria $categoria): void
    {
        $sql = "UPDATE categoria SET nome = ? WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $categoria->getNome());
        $stmt->bindValue(2, $categoria->getId());
        $stmt->execute();
    }
}
