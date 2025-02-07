<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTraits;

class ProductController extends Controller
{
    use ResponseTraits;
    public function index()
    {
        $products = app('products');
        try {
            if (empty($products)) {
                return $this->failure('Nenhum produto encontrado.', 404);
            }

            return $this->success('Produtos carregados com sucesso.', $products);
        } catch (\Throwable $th) {
            return $this->failure('Erro ao carregar produtos: ' . $th->getMessage());
        }
    }

    public function show($id)
    {
        $products = app('products');
        try {
            $product = array_filter($products, function ($product) use ($id) {
                return $product['id'] == $id;
            });

            if (empty($product)) {
                return $this->failure('Produto não encontrado.', 404);
            }

            return $this->success('Produto carregado com sucesso.', array_values($product)[0]);
        } catch (\Throwable $th) {
            return $this->failure('Erro ao carregar produto: ' . $th->getMessage());
        }
    }
}
