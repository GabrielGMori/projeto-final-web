<?php
class Venda
{
    private int $id;
    private DateTime $dataHorario;

    public function __construct(int $id, DateTime $dataHorario)
    {
        $this->id = $id;
        $this->dataHorario = $dataHorario;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDataHorario(): DateTime
    {
        return $this->dataHorario;
    }

    public function getDataFormatada(): string
    {
        return  $this->dataHorario->format('d/m/Y - H:i');
    }
}