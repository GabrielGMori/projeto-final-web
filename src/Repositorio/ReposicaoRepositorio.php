<?php
require_once __DIR__ . '/../Modelo/Reposicao.php';

class ReposicaoRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Reposicao
    {
        return new Reposicao((int)$dados['id_pk'], new DateTime($dados['data_horario']));
    }

    public function listar(): array
    {
        $sql = "SELECT id_pk, data_horario FROM reposicao ORDER BY data_horario DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        $dadosFormatados = array();
        for ($i = 0; $i < count($dados); $i++) {
            $dadosFormatados[$i] = $this->formarObjeto($dados[$i]);
        }
        return $dadosFormatados;
    }

    public function listarPaginado(string $limite, string $offset): array
    {
        $sql = "SELECT id_pk, data_horario FROM reposicao ORDER BY data_horario DESC LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limite);
        $stmt->bindValue(2, $offset);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        $dadosFormatados = array();
        for ($i = 0; $i < count($dados); $i++) {
            $dadosFormatados[$i] = $this->formarObjeto($dados[$i]);
        }
        return $dadosFormatados;
    }

    public function criar(array $pecas): void
    {
        $sql = "INSERT INTO reposicao(data_horario) VALUES (NOW())";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $reposicaoId = $this->pdo->lastInsertId();

        foreach ($pecas as $peca) {
            $sql = "INSERT INTO reposicao_tem_peca(Reposicao_id_fk_pk, Peca_id_fk_pk, preco, quantidade) VALUES (?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $reposicaoId);
            $stmt->bindValue(2, $peca['id']);
            $stmt->bindValue(3, $peca['preco']);
            $stmt->bindValue(4, $peca['quantidade']);
            $stmt->execute();
        }
    }

    public function remover(int $id): void
    {
        $sql = "DELETE FROM reposicao WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public function buscarPorId(int $id): ?Reposicao
    {
        $sql = "SELECT id_pk, data_horario FROM reposicao WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function getPecas(int $id): array {
        $sql = "SELECT Peca_id_fk_pk AS id, preco, quantidade FROM reposicao_tem_peca WHERE Reposicao_id_fk_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        return $dados;
    }

    public function contar(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM reposicao";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $dados['total'];
    }
}
