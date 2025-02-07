<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Intruções para Execução

Os dados ficticíos estão em um arquivo JSON chamado `products.json` e podem ser visualizados em `storage/app/products.json`.

Clone o repositório:
```
git clone https://github.com/JeanCSF/teste_backend_innovation.git
```


**OBS**: Antes de executar o aplicativo, certifique-se de que o Docker está instalado e configurado corretamente.

Para executar o aplicativo, execute o seguinte comando no terminal:

```
docker-compose up --build -d
```
O aplicativo será executado em http://localhost:8000.

**OBS**: Optei por não desativar a verificação CSRF, então para testar os endpoints do tipo POST em clients como Postman ou Insomnia, certifique-se de incluir o header "X-CSRF-Token" com o token gerado na rota raiz.

### Endpoints

#### GET /products

Retorna uma lista de produtos.
##### Exemplo de Resposta:
```json
{
    "status": 200,
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Produto 1",
            "price": 10.99
        },
        {
            "id": 2,
            "name": "Produto 2",
            "price": 19.99
        }
    ],
    "mensagem": "Produtos carregados com sucesso."
}
```

#### GET /products/{id}

Retorna um produto específico.
##### Exemplo de Resposta:
```json
{
    "status": 200,
    "success": true,
    "data": {
                "id": 1,
                "name": "Produto 1",
                "price": 10.99
            },
    "mensagem": "Produto carregado com sucesso."
}
```

#### POST /cart/add

Adiciona um item ao carrinho.
#### Requisição

Enviar no corpo da requisição um objeto `params` com os seguintes campos:
- `product_id` (int): ID do produto.
- `quantity` (int): Quantidade.

##### Exemplo de Corpo da Requisição:
```json
{
    "params": {
        "product_id": 1,
        "quantity": 2
    }
}
```
##### Exemplo de Resposta:
```json
{
    "status": 200,
    "success": true,
    "data": {
        "product": {
            "id": 1,
            "name": "Produto 1",
            "price": 10.99
        },
        "cartTotal": 10.99
    },
    "message": "Produto adicionado ao carrinho com sucesso."
}
```

#### GET /cart

Retorna os itens do carrinho.
##### Exemplo de Resposta:
```json
{
    "status": 200,
    "success": true,
    "data": [
        {
            "cart": [
                {
                    "id": 1,
                    "name": "Produto 1",
                    "quantity": 2,
                    "price": 10.99
                }
            ],
            "cartTotal": 21.98
        }
    ],
    "mensagem": "Carrinho carregado com sucesso."
}
```

#### POST /cart/checkout

Realiza o checkout do carrinho.

##### Exemplo de Resposta:
```json
{
    "status": 200,
    "success": true,
    "data": [],
    "message": "Compra realizada com sucesso."
}
