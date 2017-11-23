<?php

namespace LoteriaApi\Consumer\Reader;

class LoteriaNumbersNode
{
    private $numberConcurso;
    private $dataConcurso;
    private $dezenasConcurso = [];
    private $arrecadacaoConcurso;
    
    private $totalGanhadoresPrimeiroPremio;
    private $totalGanhadoresSegundoPremio;
    private $totalGanhadoresTerceiroPremio;
    
    private $valorGanhadoresPrimeiroPremio;
    private $valorGanhadoresSegundoPremio;
    private $valorGanhadoresTerceiroPremio;

    private $valorAcumuladoConcurso;
    private $valorEstimadoProximoConcurso;

    public function setNumberConcurso($numberConcurso)
    {
        $this->numberConcurso = $numberConcurso;
        return $this;
    }

    public function setDataConcurso($dataConcurso)
    {
        $this->dataConcurso = $dataConcurso;
        return $this;
    }

    public function setDezenasConcurso(array $dezenasConcurso)
    {
        $this->dezenasConcurso = $dezenasConcurso;
        return $this;
    }

    public function setArrecadacaoConcurso($arrecadacaoConcurso)
    {
        $this->arrecadacaoConcurso = $arrecadacaoConcurso;
        return $this;
    }

    public function setTotalGanhadoresPrimeiroPremio($totalGanhadores)
    {
        $this->totalGanhadoresPrimeiroPremio = $totalGanhadores;
        return $this;
    }

    public function setTotalGanhadoresSegundoPremio($totalGanhadores)
    {
        $this->totalGanhadoresSegundoPremio = $totalGanhadores;
        return $this;
    }

    public function setTotalGanhadoresTerceiroPremio($totalGanhadores)
    {
        $this->totalGanhadoresTerceiroPremio = $totalGanhadores;
        return $this;
    }

    public function setValorGanhadoresPrimeiroPremio($valorGanhadores)
    {
        $this->valorGanhadoresPrimeiroPremio = $valorGanhadores;
        return $this;
    }

    public function setValorGanhadoresSegundoPremio($valorGanhadores)
    {
        $this->valorGanhadoresSegundoPremio = $valorGanhadores;
        return $this;
    }

    public function setValorGanhadoresTerceiroPremio($valorGanhadores)
    {
        $this->valorGanhadoresTerceiroPremio = $valorGanhadores;
        return $this;
    }

    public function setValorAcumuladoConcurso($valorAcumulado)
    {
        $this->valorAcumuladoConcurso = $valorAcumulado;
        return $this;
    }

    public function setValorEstimadoProximoConcurso($valorEstimadoProximo)
    {
        $this->valorEstimadoProximoConcurso = $valorEstimadoProximo;
        return $this;
    }

    public function getNumberConcurso()
    {
        return $this->numberConcurso;
    }

    public function getDataConcurso()
    {
        return $this->dataConcurso;
    }

    public function getDezenasConcurso()
    {
        return $this->dezenasConcurso;
    }

    public function getArrecadacaoConcurso()
    {
        return $this->arrecadacaoConcurso;
    }

    public function getTotalGanhadoresPrimeiroPremio()
    {
        return $this->totalGanhadoresPrimeiroPremio;
    }

    public function getTotalGanhadoresSegundoPremio()
    {
        return $this->totalGanhadoresSegundoPremio;
    }

    public function getTotalGanhadoresTerceiroPremio()
    {
        return $this->totalGanhadoresTerceiroPremio;
    }

    public function getValorGanhadoresPrimeiroPremio()
    {
        return $this->valorGanhadoresPrimeiroPremio;
    }

    public function getValorGanhadoresSegundoPremio()
    {
        return $this->valorGanhadoresSegundoPremio;
    }

    public function getValorGanhadoresTerceiroPremio()
    {
        return $this->valorGanhadoresTerceiroPremio;
    }

    public function getValorAcumuladoConcurso()
    {
        return $this->valorAcumuladoConcurso;
    }

    public function getValorEstimadoProximoConcurso()
    {
        return $this->valorEstimadoProximoConcurso;
    }
}
