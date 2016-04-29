<?php

class EscolhaAutomovel {

    private $regras = array();
    private $valores = array();

    function __construct() {
        $this->adicionaRegra("estado", 7, array('novo' => 0,1, 'usado' => 1));
        $this->adicionaRegra("tipo", 6, array('esportivo' => 1, 'familia' => 0.1));
        $this->adicionaRegra("motor", 0.6, array('1.0' => 0.1, '1.6' => 0.6, '2.0' => 1));

        $this->adicionaValores("novo", "familia", "1.0");
        $this->adicionaValores("novo", "esportivo", "1.6");
        $this->adicionaValores("usado", "familia", "2.0");
        
    }

    private function adicionaRegra($nome, $peso, $valores) {
        $this->regras[$nome] = array(
            'peso' => $peso,
            'valores' => $valores
        );
    }
    private function adicionaValores($estado, $tipo, $motor) {
        $this->valores[] = array("estado" => $estado, "tipo" => $tipo, "motor" => $motor);
    }
    
    public function procurar($estadoEntrada, $tipoEntrada, $motorEntrada){
        $resultados = array();
        
        $estadoPeso = $this->regras['estado']['peso'];
        $tipoPeso = $this->regras['tipo']['peso'];
        $motorPeso = $this->regras['motor']['peso'];

        $somaPesos = $estadoPeso + $tipoPeso + $motorPeso;
                
        //Itera sobre cada item da tabela de veículos do estoque.
        foreach ($this->valores as $tupla) {
            $sg = 0;
            $estadoValor = $tupla["estado"];
            $pesoItemTupla = $this->regras["estado"]['valores'][$estadoValor];
            $pesoItemEntrada = $this->regras["estado"]['valores'][$estadoEntrada];
            
            $sg += ($this->regras["estado"]['peso'] * $this->mod($pesoItemTupla - $pesoItemEntrada)) / $somaPesos;
            
            $tipoValor = $tupla["tipo"];
            $pesoItemTupla = $this->regras["tipo"]['valores'][$tupla["tipo"]];
            $pesoItemEntrada = $this->regras["tipo"]['valores'][$tipoEntrada];
            
            $sg += ($this->regras["tipo"]['peso'] * $this->mod($pesoItemTupla - $pesoItemEntrada)) / $somaPesos;

            $motorValor = $tupla["motor"];
            $pesoItemTupla = $this->regras["motor"]['valores'][$tupla["motor"]];
            $pesoItemEntrada = $this->regras["motor"]['valores'][$motorEntrada];

            $sg += ($this->regras["motor"]['peso'] * $this->mod($pesoItemTupla - $pesoItemEntrada)) / $somaPesos;
            
            $percentual = $this->mod((($sg -1) *100));
            $resultados[] = array($estadoValor, $tipoValor, $motorValor, $percentual);
        }
        
        return $resultados;
    }
    public function mod($valor){
        return $valor < 0 ? $valor * -1 : $valor;
    }
    public function getValores(){
        return $this->valores;
    }
}
