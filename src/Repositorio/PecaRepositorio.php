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
        return new Peca((int)$dados['id_pk'], $dados['nome'], (int)$dados['estoque'], $dados['imagem'], (int)$dados['Categoria_id_fk']);
    }

    public function listar(): array
    {
        $sql = "SELECT id_pk, nome, estoque, imagem, Categoria_id_fk FROM peca ORDER BY nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        $dadosFormatados = array();
        for ($i = 0; $i < count($dados); $i++) {
            $dadosFormatados[$i] = $this->formarObjeto($dados[$i]);
        }
        return $dadosFormatados;
    }

    public function listarPaginadoPorCategoria(int $categoriaId, string $limite, string $offset): array
    {
        $sql = "SELECT id_pk, nome, estoque, imagem, Categoria_id_fk FROM peca WHERE Categoria_id_fk = ? ORDER BY nome LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $categoriaId);
        $stmt->bindValue(2, $limite);
        $stmt->bindValue(3, $offset);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        $dadosFormatados = array();
        for ($i = 0; $i < count($dados); $i++) {
            $dadosFormatados[$i] = $this->formarObjeto($dados[$i]);
        }
        return $dadosFormatados;
    }

    public function criar(string $nome, int $estoque, ?string $imagem, int $categoriaId): void
    {
        $sql = "INSERT INTO peca(nome, estoque, imagem, Categoria_id_fk) VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $nome);
        $stmt->bindValue(2, $estoque);
        $stmt->bindValue(3, $imagem);
        $stmt->bindValue(4, $categoriaId);
        $stmt->execute();
    }

    public function remover(int $id): void
    {
        $sql = "DELETE FROM peca WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public function editar(Peca $categoria): void
    {
        $sql = "UPDATE peca SET nome = ?, estoque = ?, imagem = ? WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $categoria->getNome());
        $stmt->bindValue(2, $categoria->getEstoque());
        $stmt->bindValue(3, $categoria->getImagem());
        $stmt->bindValue(4, $categoria->getId());
        $stmt->execute();
    }

    public function buscarPorId(int $id): ?Peca
    {
        $sql = "SELECT id_pk, nome, estoque, imagem, Categoria_id_fk FROM peca WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function contarPorCategoria(int $categoriaId) : int
    {
        $sql = "SELECT COUNT(*) AS total FROM peca WHERE Categoria_id_fk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $categoriaId);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $dados['total'];
    }

}
