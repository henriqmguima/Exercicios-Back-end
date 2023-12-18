# Prova de Programação em PHP - Cadastro de vagas de emprego

- Para a resolução da prova, os arquivos `users.php`, `jobs.php` e `applications.php` devem ser considerados como um banco de dados. Neles, você encontrará um array com os dados de usuários, vagas de emprego e candidaturas, respectivamente.
- Os arquivos que você irá alterar são `get-jobs.php`, e `apply.php`. Você deverá importar os dados acima citados para realizar as operações solicitadas.
- O códigos dos arquivos `index.html`, `index.css`, `index.js` e `toast.js` são referentes ao front-end desta atividade, e portanto, não devem ser alterados.

## 1. Listagem de vagas

Ao carregar a página, o script `get-jobs.php` é chamado. Você deve alterar este script para retornar todas as vagas de emprego contidas no array **jobs** do arquivo `jobs.php`. O retorno deve ser através de JSON no seguinte formato:

```json
{
  "status": "success",
  "message": "Lista de vagas",
  "jobs": [
    {
      "id": "id da vaga",
      "title": "título da vaga",
      "description": "descrição da vaga",
      "salary": "salário da vaga",
      "company": "empresa da vaga"
    }
  ]
}
```

## 2. Verificação de usuário

Você deve alterar o script `apply.php` para consultar os usuários cadastrados em `users.php`. O script deve receber por POST os parâmetros **email** e **password** de um usuário e retornar um JSON nos seguintes casos de erro:

### Usuário não encontrado:

```json
{
  "status": "error",
  "message": "Usuário não encontrado"
}
```

### Senha não confere com a senha do usuário:

```json
{
  "status": "error",
  "message": "Senha incorreta"
}
```

Para fins de teste, todos os usuários foram cadastrados com a senha **asdf1234**.

## 3. Candidatura a uma vaga

Ainda no script `apply.php`, após a verificação bem sucedida do usuário, você deve verificar se o usuário já se candidatou a vaga escolhida. Caso já tenha se candidatado, deve retornar o seguinte JSON:

```json
{
  "status": "error",
  "message": "Usuário já se candidatou a esta vaga"
}
```

Caso contrário, retornar o seguinte JSON:

```json
{
  "status": "success",
  "message": "Candidatura realizada com sucesso"
}
```

Lembrando que para realizar a verificação de candidatura, você deve consultar o array **applications** do arquivo `applications.php`.

A verificação da vaga escolhida pelo usuário deve ser feita através do parâmetro **jobs** recebido por POST. Este parâmetro irá receber o **id** da vaga que o usuário escolheu.