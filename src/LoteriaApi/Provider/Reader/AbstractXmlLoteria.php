<?php

namespace LoteriaApi\Provider\Reader;

use LoteriaApi\Config;

abstract class AbstractXmlLoteria implements IFinder
{
    protected $configPath;
    protected $configDatasource;
    protected $filename;

    public function __construct(Config $configPath, Config $configDatasource)
    {
        $this->configPath = $configPath;
        $this->configDatasource = $configDatasource;
        $this->putFileName();
    }

    abstract protected function putFileName();

    private function formatResultXpathToConcursoArray($resultXpath)
    {
        $arrayConcursos = [];

        foreach ($resultXpath as $key => $concurso) {
            $arrayConcursos[$key]['concurso'] = (string) $concurso->attributes()->numero;

            $children = $concurso[0]->children();

            $arrayConcursos[$key]['data'] = (string) $children->data;
            $arrayConcursos[$key]['dezenas'] = (array) $children->dezenas->children()->dezena;
            $arrayConcursos[$key]['arrecadacao'] = (string) $children->arrecadacao;
            $arrayConcursos[$key]['total_ganhadores_primeiro_premio'] = (string) $children->total_ganhadores_primeiro_premio;
            $arrayConcursos[$key]['total_ganhadores_segundo_premio'] = (string) $children->total_ganhadores_segundo_premio;
            $arrayConcursos[$key]['total_ganhadores_terceiro_premio'] = (string) $children->total_ganhadores_terceiro_premio;
            $arrayConcursos[$key]['valor_ganhadores_primeiro_premio'] = (string) $children->valor_ganhadores_primeiro_premio;
            $arrayConcursos[$key]['valor_ganhadores_segundo_premio'] = (string) $children->valor_ganhadores_segundo_premio;
            $arrayConcursos[$key]['valor_ganhadores_terceiro_premio'] = (string) $children->valor_ganhadores_terceiro_premio;
            $arrayConcursos[$key]['acumulado'] = (string) $children->acumulado;
            $arrayConcursos[$key]['valor_acumulado'] = (string) $children->valor_acumulado;
            $arrayConcursos[$key]['valor_estimado_proximo_concurso'] = (string) $children->valor_estimado_proximo_concurso;
        }

        return $arrayConcursos;
    }

    private function getSimpleXml()
    {
        return simplexml_load_file($this->filename);
    }

    public function findByConcurso($nrconcurso)
    {
        $concurso = $this->getSimpleXml()
            ->xpath("/concursos/concurso[@numero='{$nrconcurso}']");

        if (!isset($concurso[0])) {
             throw new \InvalidArgumentException("Concurso does not exist");
        }
        
        $concurso = $this->formatResultXpathToConcursoArray($concurso);

        return $concurso[0];
    }

    public function findLatestConcursos($nrconcursoRange)
    {
        // Get last concurso
        $lastConcurso = $this->findLastConcurso();

        // Range bounds
        $rangeIni = (($lastConcurso['concurso'] + 1) - $nrconcursoRange);
        $rangeEnd = $lastConcurso['concurso'];

        foreach (range($rangeIni, $rangeEnd) as $nrconcurso) {
            $concursos[] = $this->findByConcurso($nrconcurso);
        }

        return $concursos;
    }

    public function findLastConcurso()
    {
        $concurso = $this->getSimpleXml()
            ->xpath("(/concursos/concurso)[last()]");
        
        $concurso = $this->formatResultXpathToConcursoArray($concurso);

        if (!isset($concurso[0])) {
             throw new \InvalidArgumentException("Last concurso not found");
        }

        return $concurso[0];
    }
}
