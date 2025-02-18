#!/bin/bash
# Configurações de idioma e inicialização
export LANG=pt_BR.UTF-8
clear

# Atalhos para atualizar o Termux e instalar versões do Python
alias reload='source ~/.bashrc'
alias checkupdates='apt update && apt upgrade -y'
alias installpython='apt install python'
alias installpython2='apt install python2'
alias installrepo='pkg i tur-repo -y'
alias installpython3.7='pkg i python3.7 -y'
alias installpython3='pkg install python-is-python3.7'
alias checknano='nano ~/.bashrc'
alias storage='termux-setup-storage'
alias repo0='cd /storage/emulated/0/BLACKGHOST/repoblackghost'
alias repo1='cd /storage/emulated/0/BLACKGHOST/blackghost'

# Criação do diretório, se não existir
DIR="/storage/emulated/0/BLACKGHOST"
if [ ! -d "$DIR" ]; then
    mkdir -p "$DIR"
    echo "Pasta '$DIR' criada."
else
    echo "Pasta '$DIR' já existe."
fi

# Navegar até o diretório criado
cd "$DIR"

# Exibir o banner estiloso
printf "\e[1;32m             --------------------------------\n"
printf "\e[1;32m                 ▀█▀ █▀▀ █▀█ █▀▄▀█ █░█ ▀▄▀\n"
printf "\e[1;32m                 ░█░ ██▄ █▀▄ █░▀░█ █▄█ █░█\n"
printf "\e[1;36m                ┫🔱🎩┣ @𝙱𝙻𝙰𝙲𝙺𝙶𝙷𝙾𝚂𝚃_𝙱 ┫🎩🔱┣\n"
printf "\e[1;32m             --------------------------------\n"

# Configuração do prompt para nome verde e texto digitado em >
export PS1='\e[1;32m @ᏴᏞᎪᏟᏦᏀᎻϴՍͲ [ㄓ]\e[1;37m ➔ '

# Mensagem ao sair com atraso
trap 'echo -e "\n\e[1;31mObrigado por usar o Termux! Até logo!"' EXIT
