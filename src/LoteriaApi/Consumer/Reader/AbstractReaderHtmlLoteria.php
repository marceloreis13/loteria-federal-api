<?php

namespace LoteriaApi\Consumer\Reader;

use \DOMDocument;
use \DOMNodeList;
use \DomXPath;

abstract class AbstractReaderHtmlLoteria implements IReaderHtml
{
    protected $domdocument;
    protected $numbersNode;
    protected $data = [];

    abstract public function getData();
    abstract public function getDataLive();

    public function setDOMDocument(DOMDocument $domdocument)
    {
        $this->domdocument = $domdocument;
        return $this;
    }

    public function setNumbersNode(LoteriaNumbersNode $numbersNode)
    {
        $this->numbersNode = $numbersNode;
        return $this;
    }

    protected function loadData(LoteriaNumbersNode $numbersNode)
    {
        $table = $this->domdocument->getElementsByTagName('table')->item(0);
        $trs = $table->getElementsByTagName('tr');

        for ($concursoHtml = 1; $concursoHtml < $trs->length; $concursoHtml++) {
            $tds = $trs->item($concursoHtml)->getElementsByTagName('td');
            
            $nrconcurso = $tds->item($numbersNode->getNumberConcurso())->nodeValue;

            $data = $tds->item($numbersNode->getDataConcurso())->nodeValue;
            $dezenas = $this->loadDezenas($numbersNode, $tds);
            $arrecadacao = isset($tds->item($numbersNode->getArrecadacaoConcurso())->nodeValue) ? $tds->item($numbersNode->getArrecadacaoConcurso())->nodeValue : "";
            $totalGanhadoresPrimeiroPremio = isset($tds->item($numbersNode->getTotalGanhadoresPrimeiroPremio())->nodeValue) ? $tds->item($numbersNode->getTotalGanhadoresPrimeiroPremio())->nodeValue : "";
            $totalGanhadoresSegundoPremio = isset($tds->item($numbersNode->getTotalGanhadoresSegundoPremio())->nodeValue) ? $tds->item($numbersNode->getTotalGanhadoresSegundoPremio())->nodeValue : "";
            $totalGanhadoresTerceiroPremio = isset($tds->item($numbersNode->getTotalGanhadoresTerceiroPremio())->nodeValue) ? $tds->item($numbersNode->getTotalGanhadoresTerceiroPremio())->nodeValue : "";
            $valorGanhadoresPrimeiroPremio = isset($tds->item($numbersNode->getValorGanhadoresPrimeiroPremio())->nodeValue) ? $tds->item($numbersNode->getValorGanhadoresPrimeiroPremio())->nodeValue : "";
            $valorGanhadoresSegundoPremio = isset($tds->item($numbersNode->getValorGanhadoresSegundoPremio())->nodeValue) ? $tds->item($numbersNode->getValorGanhadoresSegundoPremio())->nodeValue : "";
            $valorGanhadoresTerceiroPremio = isset($tds->item($numbersNode->getValorGanhadoresTerceiroPremio())->nodeValue) ? $tds->item($numbersNode->getValorGanhadoresTerceiroPremio())->nodeValue : "";
            $valorAcumulado = isset($tds->item($numbersNode->getValorAcumuladoConcurso())->nodeValue) ? $tds->item($numbersNode->getValorAcumuladoConcurso())->nodeValue : "";
            $valorEstimadoProximoConcurso = isset($tds->item($numbersNode->getValorEstimadoProximoConcurso())->nodeValue) ? $tds->item($numbersNode->getValorEstimadoProximoConcurso())->nodeValue : "";
            $acumulado = $totalGanhadoresPrimeiroPremio === '0' ? 'SIM' : 'NÃO';

            $this->data[$nrconcurso] = [
                'data' => $data,
                'dezenas' => $dezenas,
                'arrecadacao' => $arrecadacao,
                'total_ganhadores_primeiro_premio' => $totalGanhadoresPrimeiroPremio,
                'total_ganhadores_segundo_premio' => $totalGanhadoresSegundoPremio,
                'total_ganhadores_terceiro_premio' => $totalGanhadoresTerceiroPremio,
                'valor_ganhadores_primeiro_premio' => $valorGanhadoresPrimeiroPremio,
                'valor_ganhadores_segundo_premio' => $valorGanhadoresSegundoPremio,
                'valor_ganhadores_terceiro_premio' => $valorGanhadoresTerceiroPremio,
                'acumulado' => $acumulado,
                'valor_acumulado' => $valorAcumulado,
                'valor_estimado_proximo_concurso' => $valorEstimadoProximoConcurso,
            ];
        }
    }

    private function loadDezenas(LoteriaNumbersNode $numbersNode, DOMNodeList $tds)
    {
        $dezenas = [];

        foreach ($numbersNode->getDezenasConcurso() as $dezenaConcurso) {
            if (isset($tds->item($dezenaConcurso)->nodeValue)) {
                $dezenas[] = $tds->item($dezenaConcurso)->nodeValue;
            }
        }

        return $dezenas;
    }

    protected function loadDezenasLive(DOMNodeList $nodes) {
        $dezenas = [];
        foreach ($nodes as $node) {
            $dezenas[] = $node->nodeValue;
        }

        return $dezenas;        
    }
}
