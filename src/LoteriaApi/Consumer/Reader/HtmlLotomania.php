<?php

namespace LoteriaApi\Consumer\Reader;

use \DOMDocument;
use \DOMNodeList;
use \DomXPath;

class HtmlLotomania extends AbstractReaderHtmlLoteria
{
    public function getData()
    {
        $this->numbersNode->setNumberConcurso(0)
            ->setDataConcurso(1)
            ->setDezenasConcurso([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21])
            ->setArrecadacaoConcurso(22)
            ->setTotalGanhadoresPrimeiroPremio(23)
            ->setTotalGanhadoresSegundoPremio(26)
            ->setTotalGanhadoresTerceiroPremio(27)
            ->setValorGanhadoresPrimeiroPremio(31)
            ->setValorGanhadoresSegundoPremio(32)
            ->setValorGanhadoresTerceiroPremio(33)
            ->setValorAcumuladoConcurso(37)
            ->setValorEstimadoProximoConcurso(43);

        parent::loadData($this->numbersNode);

        return $this->data;
    }

        public function getDataLive() {

        // Instance for query
        $finder = new DomXPath($this->domdocument);        

        // Concurso
        $nodes = $finder->query("//div[contains(@class, 'title-bar')]");
        $domConcurso = $nodes->item(0);
        preg_match('/ ([0-9]{4,}) \((.*?)\)/', $domConcurso->nodeValue, $map);
        $nrconcurso = trim($map[1]);

        // Data
        $data = trim($map[2]);

        // Dezenas
        $nodes = $finder->query("//table[contains(@class, 'simple-table')][contains(@class, 'lotomania')]/tr/td");
        $dezenas = parent::loadDezenasLive($nodes);

        // Arrecadacao
        $nodes = $finder->query("//div[contains(@class, 'related-box')][contains(@class, 'gray-text')]/p/strong");
        $arrecadacao = trim(preg_replace('/[^0-9,\.]/si', '', $nodes->item(7)->nodeValue));

        // Total ganhadores primeiro premio
        $nodes = $finder->query("//div[contains(@class, 'related-box')][contains(@class, 'gray-text')]/p");
        preg_match('/([0-9]*?) aposta/', $nodes->item(0)->nodeValue, $map);
        $totalGanhadoresPrimeiroPremio = isset($map[1]) ? trim(preg_replace('/[^0-9]/si', '', $map[1])) : "";
        $totalGanhadoresPrimeiroPremio = empty($totalGanhadoresPrimeiroPremio) ? 0 : $totalGanhadoresPrimeiroPremio;

        // Total ganhadores segundo premio
        $nodes = $finder->query("//div[contains(@class, 'related-box')][contains(@class, 'gray-text')]/p");
        preg_match('/([0-9]*?) aposta/', $nodes->item(1)->nodeValue, $map);
        $totalGanhadoresSegundoPremio = isset($map[1]) ? trim(preg_replace('/[^0-9]/si', '', $map[1])) : "";
        $totalGanhadoresSegundoPremio = empty($totalGanhadoresSegundoPremio) ? 0 : $totalGanhadoresSegundoPremio;

        // Total ganhadores terceiro premio
        $nodes = $finder->query("//div[contains(@class, 'related-box')][contains(@class, 'gray-text')]/p");
        preg_match('/([0-9]*?) aposta/', $nodes->item(2)->nodeValue, $map);
        $totalGanhadoresTerceiroPremio = isset($map[1]) ? trim(preg_replace('/[^0-9]/si', '', $map[1])) : "";
        $totalGanhadoresTerceiroPremio = empty($totalGanhadoresTerceiroPremio) ? 0 : $totalGanhadoresTerceiroPremio;

        // Valor ganhadores primeiro premio
        $nodes = $finder->query("//div[contains(@class, 'related-box')][contains(@class, 'gray-text')]/p");
        preg_match('/R\$ ([0-9,\.]*)/', $nodes->item(0)->nodeValue, $map);
        $valorGanhadoresPrimeiroPremio = isset($map[1]) ? trim(preg_replace('/[^0-9,\.]/si', '', $map[1])) : "";
        $valorGanhadoresPrimeiroPremio = empty($valorGanhadoresPrimeiroPremio) ? 0 : $valorGanhadoresPrimeiroPremio;

        // Valor ganhadores segundo premio
        $nodes = $finder->query("//div[contains(@class, 'related-box')][contains(@class, 'gray-text')]/p");
        preg_match('/R\$ ([0-9,\.]*)/', $nodes->item(1)->nodeValue, $map);
        $valorGanhadoresSegundoPremio = isset($map[1]) ? trim(preg_replace('/[^0-9,\.]/si', '', $map[1])) : "";
        $valorGanhadoresSegundoPremio = empty($valorGanhadoresSegundoPremio) ? 0 : $valorGanhadoresSegundoPremio;

        // Valor ganhadores terceiro premio
        $nodes = $finder->query("//div[contains(@class, 'related-box')][contains(@class, 'gray-text')]/p");
        preg_match('/R\$ ([0-9,\.]*)/', $nodes->item(2)->nodeValue, $map);
        $valorGanhadoresTerceiroPremio = isset($map[1]) ? trim(preg_replace('/[^0-9,\.]/si', '', $map[1])) : "";
        $valorGanhadoresTerceiroPremio = empty($valorGanhadoresTerceiroPremio) ? 0 : $valorGanhadoresTerceiroPremio;

        // Valor Acumulado
        $nodes = $finder->query("//div[contains(@class, 'totals')]/p/span[contains(@class, 'value')]");
        $valorAcumulado = isset($nodes->item(0)->nodeValue) ? trim(preg_replace('/[^0-9,\.]/si', '', $nodes->item(0)->nodeValue)) : "";
        $valorAcumulado = empty($valorAcumulado) ? 0 : $valorAcumulado;

        // Acumulado
        $acumulado = $valorGanhadoresPrimeiroPremio > 0 ? 'NÃO' : 'SIM';

        // Valor estimado proximo concurso
        $nodes = $finder->query("//div[contains(@class, 'next-prize')]/p[contains(@class, 'value')]");
        $valorEstimadoProximoConcurso = isset($nodes->item(0)->nodeValue) ? trim(preg_replace('/[^0-9,\.]/si', '', $nodes->item(0)->nodeValue)) : "";
        $valorEstimadoProximoConcurso = empty($valorEstimadoProximoConcurso) ? 0 : $valorEstimadoProximoConcurso;

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

        return $this->data;
    }
}
