# Projeto Clinica Patusco

## Descrição

Este é um projeto de gerenciamento de consultas para uma clínica veterinária. O sistema permite que usuários façam agendamentos, que médicos visualizem e gerenciem consultas, e que recepcionistas atribuam consultas e visualizem o status das mesmas.

## Funcionalidades

- **Usuários:**
  - Agendar consultas.
  - Visualizar consultas agendadas.

- **Recepcionistas:**
  - Visualizar todas as consultas.
  - Atribuir médicos às consultas.
  - Alterar o status das consultas.

- **Médicos:**
  - Visualizar consultas atribuídas.
  - Alterar o status das consultas.
  - Adicionar observações às consultas.

## Tecnologias Utilizadas

- **Backend:**
  - Laravel 8
  - MySQL

- **Frontend:**
  - Vue.js 3
  - Vuetify
  - Axios

- **Outras Ferramentas:**
  - Composer
  - Node.js
  - NPM

## Requisitos

- PHP >= 7.4
- Composer
- Node.js
- NPM
- MySQL

## Instalação

1. Clone o repositório:

    ```bash
    git clone https://github.com/seu-usuario/projeto-clinica-patusco.git
    cd projeto-clinica-patusco
    ```

2. Instale as dependências do backend:

    ```bash
    composer install
    ```

3. Instale as dependências do frontend:

    ```bash
    npm install
    ```

4. Configure o arquivo `.env`:

    ```bash
    cp .env.example .env
    ```

5. Gere a chave da aplicação:

    ```bash
    php artisan key:generate
    ```

6. Configure o banco de dados no arquivo `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nome_do_banco
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
    ```

7. Execute as migrações e seeders:

    ```bash
    php artisan migrate --seed
    ```

8. Inicie o servidor de desenvolvimento do backend:

    ```bash
    php artisan serve
    ```

9. Inicie o servidor de desenvolvimento do frontend:

    ```bash
    npm run dev
    ```

## Uso

1. Acesse o sistema através do navegador no endereço:

    ```
    http://localhost:8000
    ```

2. Faça o login com as credenciais de usuário, recepcionista ou médico.

3. Navegue pelo sistema para gerenciar consultas conforme as permissões do seu usuário.

## Rotas da API

### Usuários

- `GET /api/user` - Retorna os dados do usuário logado.
- `POST /api/register` - Registra um novo usuário.
- `POST /api/login` - Faz login de um usuário.
- `POST /api/logout` - Faz logout do usuário logado.

### Consultas

- `GET /api/consultas` - Retorna todas as consultas.
- `POST /api/agendamentos` - Agenda uma nova consulta.
- `PUT /api/consultas/{id}` - Atualiza uma consulta.
- `DELETE /api/consultas/{id}` - Exclui uma consulta.

### Pets

- `GET /api/showpets` - Retorna todos os pets do usuário logado.
- `POST /api/pets` - Cadastra um novo pet.
- `PUT /api/pets/{id}` - Atualiza os dados de um pet.

### Médicos

- `GET /api/medicos` - Retorna todos os médicos.


## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo LICENSE.md para detalhes.


