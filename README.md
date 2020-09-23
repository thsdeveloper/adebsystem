# AdebSystem 1.0
### **Sistema de Gerenciamento da ADEB Setor 11**
Obs. O Sistema de gerenciamento AdebSystem é exclusivo para o usu interno do gerenciamento de membros da ADEB Setor 11.

**Roteiro de Instalação do Projeto em Ambiente Local.**

1 - Verificar os requisitos mínimos para instalar o projeto.
- Git | Versão >= 2.0
- Docker | Versão >= 18.0

2 - C


Passo 1: $ npm cache clean --force

Etapa 2: exclua node_modules por $ rm -rf node_modules package-lock.jsonpasta ou exclua-o manualmente , indo para o diretório e clique com o botão direito do mouse em> excluir / mover para a lixeira. Além disso, exclua o arquivo package-lock.json também.

Etapa 3: npm install

Para começar de novo, $ npm start

Isso funcionou para mim. Espero que funcione para você também.

PS: Ainda assim, verifique o erro exibido em vermelho e aja de acordo. Este erro é específico ao ambiente node.js. Feliz codificação !!

- Caso receba um erro "not-autorized" favor correr o comando abaixo.

`php artisan cache:clear`
