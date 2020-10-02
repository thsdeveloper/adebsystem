# AdebSystem 1.0
### **Sistema de Gerenciamento da ADEB Setor 11**
Obs. O Sistema de gerenciamento AdebSystem é exclusivo para o usu interno do gerenciamento de membros da ADEB Setor 11.

**Roteiro de Instalação do Projeto em Ambiente Local.**

1 - Verificar os requisitos mínimos para instalar o projeto.
- Git | Versão >= 2.0
- Docker | Versão >= 18.0

2 - Clonar o laradock no ambiente local.

- `git clone https://github.com/laradock/laradock.git`

3 - Limpar o cache do npm e excluir o node_modules e package.lock.json
- `npm cache clean --force`
- `rm -rf node_modules`
- `rm -rf package-lock.json`
-  `nvm install 10`
- `npm install`
- `npm run dev`

4 - Instalação das dependências do composer.json

- `composer install`
- `php artisan key:generate`
- `php artisan jwt:secret`

5 - Subir banco de dados e depedências do banco.

- `php artisan migrate:status`
- `php artisan migrate`
- `php artisan db:seed`
- `docker-compose exec --user=root workspace bash`

Isso funcionou para mim. Espero que funcione para você também.

composer create-project --prefer-dist cretueusebiu/laravel-vue-spa
Edit .env and set your database connection details
(When installed via git clone or download, run php artisan key:generate and php artisan jwt:secret)
php artisan migrate
npm install



PS: Ainda assim, verifique o erro exibido em vermelho e aja de acordo. Este erro é específico ao ambiente node.js. Feliz codificação !!

- Caso receba um erro "not-autorized" favor correr o comando abaixo.

`php artisan cache:clear`

- Para visualizar os arquivos

`php artisan storage:link`

- 
