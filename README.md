#Loteria Federal Api

Este projeto tem como objetivo fornecer dados da loteria da Caixa Econômica Federal através de uma api.

## Instalação

Baixe o projeto. 
```
git clone git@github.com:marceloreis13/loteria-federal-api.git
```

Execute o build.
```
php phing.phar
```

##### Requisitos mínimos
* PHP >= 5.4

## Como funciona 
A api é basicamente composta por duas partes, uma que consome os dados da Caixa e outro que fornece estes dados.

- - -

###Consumer
Esta parte é executada por um script em ```bin/consumer```.
```
$ bin/consumer
```

1. Baixa os dados da loteria através das urls em ```etc/datasource.ini```.
2. Descompacta o arquivo.
3. Consome o arquivo e parseia-o para um xml amigavel em ```var/xml```.

###Provider

1. Recebe a requisição através de rotas definidas.
2. Consome o xml com os dados.
3. Entrega os dados para o usuário em json.

- - -

#### Exemplo de chamadas a API

```
https://seudominio.com.br/web/?loteria=megasena
```
###Trás os dados do último concurso realizado pela Caixa Econômica

```
https://seudominio.com.br/web/?loteria=megasena&latest=10
```
###Trás os dados dos 10 últimos concursos realizado pela Caixa Econômica

```
https://seudominio.com.br/web/?loteria=megasena&concurso=1988
```
###Trás os dados do concurso 1988 realizado pela Caixa Econômica


## Autor

[Marcelo Reis](http://marcelo.cc) :email: [Email](mailto:me@marcelo.cc)

## License

This project is licensed under the MIT License - see the [License File](LICENSE) for details