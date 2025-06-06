from flask import Flask, render_template_string, request
import subprocess

REPO_PATH = "/storage/emulated/0/Download/blackghost-dev.github.io"

app = Flask(__name__)

HTML = '''
<!DOCTYPE html>
<html>
<head>
    <title>Git Web UI</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f9f9f9; }
        input[type="text"], input[type="password"] {
            width: 100%%; max-width: 400px; padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc; border-radius: 4px;
        }
        button {
            margin: 5px; padding: 10px 18px;
            background-color: #4CAF50; color: white;
            border: none; border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background-color: #45a049; }
        pre {
            background-color: #eee; padding: 10px;
            border-radius: 5px; overflow-x: auto;
        }
    </style>
</head>
<body>
    <h2>Git Web UI</h2>
    <form method="post">
        <input type="text" name="message" placeholder="Mensagem do commit (git commit -m)"><br>
        <input type="text" name="remote_url" placeholder="URL do repositório remoto (ex: https://github.com/...)"><br>
        <input type="password" name="github_token" placeholder="Token do GitHub"><br>
        <br>
        <button name="action" value="status">Git Status</button>
        <button name="action" value="add">Git Add</button>
        <button name="action" value="commit">Git Commit</button>
        <button name="action" value="pull">Git Pull</button>
        <button name="action" value="push">Git Push</button>
    </form>
    <br>
    <h3>Saída:</h3>
    <pre>{{ output }}</pre>
</body>
</html>
'''

def rodar(comando):
    try:
        resultado = subprocess.check_output(comando, shell=True, cwd=REPO_PATH, stderr=subprocess.STDOUT)
        return resultado.decode()
    except subprocess.CalledProcessError as e:
        return e.output.decode()

@app.route("/", methods=["GET", "POST"])
def index():
    output = ""
    if request.method == "POST":
        action = request.form["action"]
        msg = request.form.get("message", "")
        remote_url = request.form.get("remote_url", "").strip()
        token = request.form.get("github_token", "").strip()

        if action == "status":
            output = rodar("git status")
        elif action == "add":
            output = rodar("git add .")
        elif action == "commit":
            output = rodar(f'git commit -m "{msg}"')
        elif action == "pull":
            output = rodar("git pull")
        elif action == "push":
            if token and remote_url:
                # Constrói a URL com o token
                url_com_token = remote_url.replace("https://", f"https://{token}@")
                output += rodar(f"git remote set-url origin {url_com_token}")
                output += rodar("git push origin main")
            else:
                output = "⚠️ Por favor, preencha o link do repositório e o token."
    return render_template_string(HTML, output=output)

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000)