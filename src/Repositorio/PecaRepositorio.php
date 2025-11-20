<?php
require_once __DIR__ . '/../Modelo/Peca.php';

class PecaRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Peca
    {
        return new Peca((int)$dados['id_pk'], $dados['nome'], (int)$dados['estoque']);
    }

    public function listar(): array
    {
        $sql = "SELECT id_pk, nome FROM peca ORDER BY nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        $dadosFormatados = array();
        for ($i = 0; $i < count($dados); $i++) {
            $dadosFormatados[$i] = $this->formarObjeto($dados[$i]);
        }
        return $dadosFormatados;
    }

    public function listarPorCategoria(int $categoriaId): array
    {
    $sql = "SELECT id_pk, nome, estoque FROM peca WHERE Categoria_id_pk = ? ORDER BY nome";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $categoriaId);
    $stmt->execute();
    $dados = $stmt->fetchAll();

    $pecas = [];
    foreach ($dados as $dado) {
        $pecas[] = $this->formarObjeto($dado);
    }
    return $pecas;
    }

    public function criar(string $nome, int $estoque, int $categoriaId): void
    {
    
    $estoque = $estoque > 0 ? $estoque : 1;
    
    $sql = "INSERT INTO peca(nome, estoque, Categoria_id_pk) VALUES (?, ?, ?)";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(1, $nome);
    $stmt->bindValue(2, $estoque);
    $stmt->bindValue(3, $categoriaId);
    $stmt->execute();
    }

    public function remover(int $id): void
    {
        $sql = "DELETE FROM peca WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public function editar(Peca $peca): void
    {
        $sql = "UPDATE peca SET nome = ?, estoque = ? WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $peca->getNome());
        $stmt->bindValue(2, $peca->getEstoque());
        $stmt->bindValue(3, $peca->getId());
        $stmt->execute();
    }

    public function buscarPorId(int $id): ?Peca
    {
        $sql = "SELECT id_pk, nome FROM peca WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }

}