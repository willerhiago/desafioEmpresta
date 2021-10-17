<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimuladorController extends Controller
{
    private $dadosSimulador;
    private $simulacao = [];

    public function simular(Request $request)
    {
        $this->carregarArquivoDadosSimulador()
             ->simularEmprestimo($request->valor_emprestimo)
             ->filtrarInstituicao($request->instituicoes)
             ->filtrarConvenio($request->convenios)
             ->filtrarParcelas($request->parcela)
        ;
        return \response()->json($this->simulacao);
    }

    private function carregarArquivoDadosSimulador() : self
    {
        $this->dadosSimulador = json_decode(\File::get(storage_path("app/public/simulador/taxas_instituicoes.json")));
        return $this;
    }

    private function simularEmprestimo(float $valorEmprestimo) : self
    {
        foreach ($this->dadosSimulador as $dados) {
            $this->simulacao[$dados->instituicao][] = [
                "taxa"            => $dados->taxaJuros,
                "parcelas"        => $dados->parcelas,
                "valor_parcela"    => $this->calcularValorDaParcela($valorEmprestimo, $dados->coeficiente),
                "convenio"        => $dados->convenio,
            ];
        }
        return $this;
    }

    private function calcularValorDaParcela(float $valorEmprestimo, float $coeficiente) : float
    {
        return round($valorEmprestimo * $coeficiente, 2);
    }

    private function filtrarInstituicao(array $instituicoes) : self
    {
        if (\count($instituicoes))
        {
            $arrayAux = [];
            foreach ($instituicoes AS $key => $instituicao)
            {
                if (\array_key_exists($instituicao, $this->simulacao))
                {
                     $arrayAux[$instituicao] = $this->simulacao[$instituicao];
                }
            }
            $this->simulacao = $arrayAux;
        }
        return $this;
    }

    private function filtrarConvenio(array $convenios) : self
    {
        if (\count($convenios))
        {
            $arrayAux = [];
            foreach ($this->simulacao as $key => $instituicao) {
                $resultado = array_filter($instituicao, function($item) use ($convenios){
                    return in_array($item['convenio'], $convenios);
                });
                $arrayAux[$key] = $resultado;
            }
            $this->simulacao = $arrayAux;
        }
        return $this;
    }

    private function filtrarParcelas(int $parcela) : self
    {
        if ($parcela !== 0)
        {
            $arrayAux = [];
            foreach ($this->simulacao as $key => $instituicao) {
                $resultado = array_filter($instituicao, function($item) use ($parcela){
                    return $item['parcelas'] == $parcela;
                });
                $arrayAux[$key] = $resultado;
            }
            $this->simulacao = $arrayAux;
        }
        return $this;
    }
}
