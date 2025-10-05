<?php
class Usuario
{
    private int $id;
    private string $email;
    private string $senha;
    private string $permissao;

    public function __construct(int $id, string $email, string $senha, string $permissao)
    {
        $this->id = $id;
        $this->email = $email;
        $this->senha = $senha;
        $this->permissao = $permissao;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getPermissao(): string
    {
        return $this->permissao;
    }
}
