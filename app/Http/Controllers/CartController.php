<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseTraits;

use function Symfony\Component\String\b;

class CartController extends Controller
{
    use ResponseTraits;

    public function addToCart(Request $request)
    {
        try {
            $products = app('products');
            $productId = $request->input('params.product_id');
            $quantity = $request->input('params.quantity', 1);

            if (!$productId) {
                return $this->failure('ID do produto é obrigatório.', 400);
            }

            $product = array_values(array_filter($products, fn($p) => $p['id'] == $productId));

            if (empty($product)) {
                return $this->failure('Produto não encontrado.', 404);
            }

            $product = $product[0];
            $cart = $this->mountCart($product, $quantity);
            $cartTotal = array_sum(array_column($cart, 'total'));

            return $this->success('Produto adicionado ao carrinho com sucesso.', [
                'product' => $product,
                'cartTotal' => $cartTotal,
            ]);
        } catch (\Throwable $th) {
            return $this->failure('Erro ao adicionar produto ao carrinho: ' . $th->getMessage(), 500);
        }
    }

    public function showCart()
    {
        try {
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return $this->failure('Carrinho vazio.', 404);
            }

            $cartTotal = array_sum(array_column($cart, 'total'));

            return $this->success('Carrinho carregado com sucesso.', [
                'cart' => $cart,
                'cartTotal' => round($cartTotal, 2),
            ]);
        } catch (\Throwable $th) {
            return $this->failure('Erro ao carregar carrinho: ' . $th->getMessage(), 500);
        }
    }

    public function checkout()
    {
        try {
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return $this->failure('Carrinho vazio.', 404);
            }

            session()->forget('cart');

            return $this->success('Compra realizada com sucesso.');
        } catch (\Throwable $th) {
            return $this->failure('Erro ao realizar compra: ' . $th->getMessage(), 500);
        }
    }

    private function mountCart($product, $quantity){
        $cart = session()->get('cart', []);
        $productTotalPrice = $product['price'] * $quantity;
        $existingProductKey = array_search($product['id'], array_column($cart, 'id'));
        if ($existingProductKey !== false) {
            $cart[$existingProductKey]['quantity'] += $quantity;
            $cart[$existingProductKey]['total'] = $cart[$existingProductKey]['quantity'] * $cart[$existingProductKey]['price'];
        } else {
            $cart[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'quantity' => $quantity,
                'price' => $product['price'],
                'total' => $productTotalPrice,
            ];
        }

        session()->put('cart', $cart);

        return $cart;
    }
}
