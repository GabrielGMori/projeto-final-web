<?php
class Usuario
{
    private int $id;
    private string $nome;
    private int $estoque;

    public function __construct(int $id, string $nome, int $estoque)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->estoque = $estoque;
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
   
}