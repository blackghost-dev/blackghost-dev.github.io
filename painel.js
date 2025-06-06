// Exemplo simples de código para carregar e salvar usuários no GitHub
const repoInfo = {
  owner: "blackghost-dev",
  repo: "blackghost-dev.github.io", // repositório raiz do Pages
  path: "usuarios.json"
};

async function carregarUsuarios() {
  const token = document.getElementById('token').value;
  if (!token) { alert('Informe o token!'); return; }
  const url = `https://api.github.com/repos/${repoInfo.owner}/${repoInfo.repo}/contents/${repoInfo.path}`;
  const resp = await fetch(url, {
    headers: { Authorization: 'token ' + token }
  });
  if (!resp.ok) { alert('Erro ao carregar. Confira o token e permissões.'); return; }
  const data = await resp.json();
  const content = atob(data.content);
  const json = JSON.parse(content);
  mostrarUsuarios(json.usuarios);
}

function mostrarUsuarios(usuarios) {
  const container = document.getElementById('usuariosContainer');
  container.innerHTML = '';
  usuarios.forEach((u, i) => {
    const div = document.createElement('div');
    div.innerHTML = `
      <input placeholder="Usuário" value="${u.usuario}" data-index="${i}" class="usuario" />
      <input placeholder="Senha" value="${u.senha}" data-index="${i}" class="senha" />
      <input placeholder="VIP (true/false)" value="${u.vip}" data-index="${i}" class="vip" />
      <input placeholder="Expira em (YYYY-MM-DD)" value="${u.expira_em}" data-index="${i}" class="expira" />
      <input placeholder="URL da lista M3U" value="${u.lista_url}" data-index="${i}" class="lista" />
    `;
    container.appendChild(div);
  });
}

async function salvarUsuarios() {
  const token = document.getElementById('token').value;
  if (!token) { alert('Informe o token!'); return; }
  const usuarios = [];
  document.querySelectorAll('#usuariosContainer > div').forEach(div => {
    usuarios.push({
      usuario: div.querySelector('.usuario').value,
      senha: div.querySelector('.senha').value,
      vip: div.querySelector('.vip').value === 'true',
      expira_em: div.querySelector('.expira').value,
      lista_url: div.querySelector('.lista').value
    });
  });
  const contentStr = JSON.stringify({ usuarios }, null, 2);
  const contentBase64 = btoa(contentStr);

  // Obter sha do arquivo atual para atualizar
  const url = `https://api.github.com/repos/${repoInfo.owner}/${repoInfo.repo}/contents/${repoInfo.path}`;
  const getResp = await fetch(url, {
    headers: { Authorization: 'token ' + token }
  });
  if (!getResp.ok) { alert('Erro ao buscar arquivo para atualização.'); return; }
  const getData = await getResp.json();
  const sha = getData.sha;

  // Atualizar o arquivo
  const putResp = await fetch(url, {
    method: 'PUT',
    headers: { 
      'Authorization': 'token ' + token,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      message: "Atualização via painel VIP",
      content: contentBase64,
      sha: sha
    })
  });
  if (putResp.ok) alert('Usuários salvos com sucesso!');
  else alert('Erro ao salvar usuários.');
}
