#check system

if grep -qi "ubuntu" /etc/os-release 2>/dev/null; then
    echo "Ubuntu system detected. Updating packages..."
    su apt update && apt upgrade -y && apt install -y git curl wget build-essential php xampp mysql-client
elif grep -qi "arch" /etc/os-release 2>/dev/null; then
    echo "Arch Linux system detected. Updating packages..."
    sudo pacman -Syu --noconfirm && pacman -S --noconfirm git curl wget base-devel php xampp mariadb-clients
else
    echo "Unsupported Linux distribution. Please install dependencies manually."
fi

#start xampp

sudo xampp start startapache
sudo xampp start startmysql


#setup user and passwd

read -p "Enter username: " username
read -s -p "Enter password: " password
echo "Creating user $username into database..."

