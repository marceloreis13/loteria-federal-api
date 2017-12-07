<?php

namespace LoteriaApi\Consumer;

class Writer {
    private $datasource;
    private $localstorage;
    private $data;
    private $filename;
    
    public function setDataSource(array $datasource)
    {
        $this->datasource = $datasource;
        return $this;
    }
    
    public function setLocalStorage($localstorage)
    {
        $this->localstorage = $localstorage;
        return $this;
    }
    
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
    
    public function run()
    {
        foreach ($this->datasource as $concursoName => $concurso) {
            
            $xml = new \SimpleXMLElement('<concursos/>');
            
            foreach ($this->data[$concursoName] as $nrconcurso => $concursoData) {
                if (is_numeric($nrconcurso)) {
                    $concursoXml = $xml->addChild('concurso');
                    $concursoXml->addAttribute('numero', $nrconcurso);
                    $concursoXml->addChild('data', $concursoData['data']);
                    $dezenas = $concursoXml->addChild('dezenas');
                    foreach ($concursoData['dezenas'] as $dezena) {
                        $dezenas->addChild('dezena', $dezena);
                    }
                    $concursoXml->addChild('arrecadacao', $concursoData['arrecadacao']);
                    $concursoXml->addChild('total_ganhadores_primeiro_premio', $concursoData['total_ganhadores_primeiro_premio']);
                    $concursoXml->addChild('total_ganhadores_segundo_premio', $concursoData['total_ganhadores_segundo_premio']);
                    $concursoXml->addChild('total_ganhadores_terceiro_premio', $concursoData['total_ganhadores_terceiro_premio']);
                    $concursoXml->addChild('valor_ganhadores_primeiro_premio', $concursoData['valor_ganhadores_primeiro_premio']);
                    $concursoXml->addChild('valor_ganhadores_segundo_premio', $concursoData['valor_ganhadores_segundo_premio']);
                    $concursoXml->addChild('valor_ganhadores_terceiro_premio', $concursoData['valor_ganhadores_terceiro_premio']);
                    $concursoXml->addChild('acumulado', $concursoData['acumulado']);
                    $concursoXml->addChild('valor_acumulado', $concursoData['valor_acumulado']);
                    $concursoXml->addChild('valor_estimado_proximo_concurso', $concursoData['valor_estimado_proximo_concurso']);
                }
            }
            
            $filename = $this->localstorage . $concurso['xml'];
            
            $dom = new \DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $dom->save($filename);
        }
    }

    private function getSimpleXml()
    {
        return simplexml_load_file($this->filename);
    }

   public function runLive() {
        foreach ($this->datasource as $concursoName => $concurso) {

            // File of oldest consursos
            $this->filename = $this->localstorage . $concurso['xml'];
            
            // Create new xml content
            $xml = new \SimpleXMLElement('<concursos/>');

            // Start XML from oldest concursos
            if (is_file($this->filename)) {
                $xml = $this->getSimpleXml();
            }

            foreach ($this->data[$concursoName] as $nrconcurso => $concursoData) {

                if (is_numeric($nrconcurso) && !$this->concursoExists($nrconcurso)) {
                    $concursoXml = $xml->addChild('concurso');
                    $concursoXml->addAttribute('numero', $nrconcurso);
                    $concursoXml->addChild('data', $concursoData['data']);
                    $dezenas = $concursoXml->addChild('dezenas');
                    foreach ($concursoData['dezenas'] as $dezena) {
                        $dezenas->addChild('dezena', $dezena);
                    }
                    $concursoXml->addChild('arrecadacao', $concursoData['arrecadacao']);
                    $concursoXml->addChild('total_ganhadores_primeiro_premio', $concursoData['total_ganhadores_primeiro_premio']);
                    $concursoXml->addChild('total_ganhadores_segundo_premio', $concursoData['total_ganhadores_segundo_premio']);
                    $concursoXml->addChild('total_ganhadores_terceiro_premio', $concursoData['total_ganhadores_terceiro_premio']);
                    $concursoXml->addChild('valor_ganhadores_primeiro_premio', $concursoData['valor_ganhadores_primeiro_premio']);
                    $concursoXml->addChild('valor_ganhadores_segundo_premio', $concursoData['valor_ganhadores_segundo_premio']);
                    $concursoXml->addChild('valor_ganhadores_terceiro_premio', $concursoData['valor_ganhadores_terceiro_premio']);
                    $concursoXml->addChild('acumulado', $concursoData['acumulado']);
                    $concursoXml->addChild('valor_acumulado', $concursoData['valor_acumulado']);
                    $concursoXml->addChild('valor_estimado_proximo_concurso', $concursoData['valor_estimado_proximo_concurso']);
                }
            }

            $dom = new \DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $dom->save($this->filename);
        }
    }

    private function concursoExists($nrconcurso) {
        $concurso = $this->getSimpleXml()->xpath("/concursos/concurso[@numero='{$nrconcurso}']");

        return isset($concurso[0]);
    }
}
