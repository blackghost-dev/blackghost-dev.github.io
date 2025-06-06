# Painel VIP IPTV para Add-on Kodi

Este painel simples permite gerenciar usuários VIP e suas listas M3U diretamente no GitHub, usando a API do GitHub para editar o arquivo `usuarios.json`.

## Como usar

1. Crie um repositório no GitHub com um arquivo chamado `usuarios.json` com o conteúdo inicial:

```json
{
  "usuarios": []
}
```

2. No arquivo `painel.js`, configure suas informações:

```js
const repoInfo = {
  owner: "SEU_USUARIO_GITHUB",
  repo: "SEU_REPO",
  path: "usuarios.json"
};
```

3. Gere um [Personal Access Token](https://github.com/settings/tokens) no GitHub com permissão `repo` para editar o repositório.

4. Hospede os arquivos (`index.html`, `painel.js`, `style.css`) em algum servidor web ou GitHub Pages.

5. Acesse o painel, informe seu token, clique em “Carregar Usuários do GitHub”, faça alterações e clique em “Salvar no GitHub”.

6. No seu add-on Kodi, faça o load do arquivo `usuarios.json` para validar e liberar o acesso VIP conforme os dados atualizados.

---

## Estrutura do arquivo `usuarios.json`

```json
{
  "usuarios": [
    {
      "usuario": "user1",
      "senha": "senha123",
      "vip": true,
      "expira_em": "2025-12-31",
      "lista_url": "https://exemplo.com/lista.m3u"
    }
  ]
}
```

---

## Segurança

**Importante:** Nunca compartilhe seu token do GitHub. Ele permite editar seu repositório.

---

## Personalização

Você pode adaptar o painel para incluir outras informações, como permissões específicas ou logs de acesso.

---

Criado por ChatGPT para ajudar na gestão do seu add-on Kodi VIP.
