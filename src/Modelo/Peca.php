<?php
class Peca
{
    private int $id;
    private string $nome;
    private int $estoque;
    private ?string $imagem;
    private int $categoriaId;

    public function __construct(int $id, string $nome, int $estoque, ?string $imagem, int $categoriaId)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->estoque = $estoque;
        $this->imagem = $imagem;
        $this->categoriaId = $categoriaId;
    }

    public function getId(): int
    {
        return $this->id;
    }
    
    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEstoque(): int
    {
        return $this->estoque;
    }

    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }
   
}