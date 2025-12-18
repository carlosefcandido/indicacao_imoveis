# Sistema de Indicação de Imóveis

Este é um sistema simples de indicação de imóveis.

## Requisitos

*   PHP 7.4 ou superior
*   MySQL
*   Servidor web (Apache, Nginx, etc.)

## Instalação

1.  **Clone o repositório ou baixe os arquivos.**
2.  **Crie o banco de dados:**
    *   Importe o arquivo `database.sql` para o seu servidor MySQL. Isso criará o banco de dados `indicacao_imoveis` e as tabelas `usuarios` e `imoveis`.
3.  **Configure a conexão com o banco de dados:**
    *   Abra o arquivo `php/db.php`.
    *   Altere as variáveis `$servername`, `$username`, `$password`, e `$dbname` com as suas credenciais do MySQL.
4.  **Acesse o sistema:**
    *   Abra o seu navegador e acesse o diretório do projeto no seu servidor web.

## Como usar

1.  **Cadastro:**
    *   Acesse a página de cadastro para criar um novo usuário.
    *   O primeiro usuário pode ser cadastrado sem estar logado. Novos usuários só podem ser cadastrados por um administrador.
2.  **Login:**
    *   Use o e-mail e a senha cadastrados para fazer o login.
3.  **Usuário comum:**
    *   Pode cadastrar novas indicações de imóveis.
    *   Pode ver o status das suas indicações.
4.  **Administrador:**
    *   Tem acesso a todas as indicações de todos os usuários.
    *   Pode alterar o status de cada indicação.
    *   Pode cadastrar novos usuários (tanto administradores quanto usuários comuns).
