Passo 1: $ npm cache clean --force

Etapa 2: exclua node_modules por $ rm -rf node_modules package-lock.jsonpasta ou exclua-o manualmente , indo para o diretório e clique com o botão direito do mouse em> excluir / mover para a lixeira. Além disso, exclua o arquivo package-lock.json também.

Etapa 3: npm install

Para começar de novo, $ npm start

Isso funcionou para mim. Espero que funcione para você também.

PS: Ainda assim, verifique o erro exibido em vermelho e aja de acordo. Este erro é específico ao ambiente node.js. Feliz codificação !!