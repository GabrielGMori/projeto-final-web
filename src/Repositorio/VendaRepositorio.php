<?php
require_once __DIR__ . '/../Modelo/Venda.php';

class VendaRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Venda
    {
        return new Venda((int)$dados['id_pk'], $dados['data_horario']);
    }

    public function listar(): array
    {
        $sql = "SELECT id_pk, data_horario FROM venda ORDER BY data_horario DESC";

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
        $sql = "SELECT id_pk, data_horario FROM venda ORDER BY data_horario DESC LIMIT ? OFFSET ?";

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

    public function criar(Venda $venda, array $pecas): void
    {
        $sql = "INSERT INTO venda(data_horario) VALUES (NOW())";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        foreach ($pecas as $peca) {
            $sql = "INSERT INTO venda_tem_peca(Venda_id_fk_pk, Peca_id_fk_pk, preco, quantidade) VALUES (?,?,?,?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $venda->getId());
            $stmt->bindValue(2, $peca['id']);
            $stmt->bindValue(3, $peca['preco']);
            $stmt->bindValue(4, $peca['quantidade']);
            $stmt->execute();
        }
    }

    public function remover(int $id): void
    {
        $sql = "DELETE FROM venda WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public function buscarPorId(int $id): ?Venda
    {
        $sql = "SELECT id_pk, data_horario FROM venda WHERE id_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function getPecas(int $id): array {
        $sql = "SELECT Peca_id_fk_pk AS id, preco, quantidade FROM venda_tem_peca WHERE Venda_id_fk_pk = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $dados = $stmt->fetchAll();

        return $dados;
    }

    public function contar(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM venda";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $dados['total'];
    }
}
