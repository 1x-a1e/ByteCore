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

sudo /opt/lampp/lampp startapache
sudo /opt/lampp/lampp startmysql


#setup user and passwd

read -p "Enter name: " nome
read -p "Enter email: " email
read -p "Enter username: " username
read -s -p "Enter password: " password
echo
echo "Hashing password..."
hashed_password=$(echo "$password" | php -r '$p = trim(fgets(STDIN)); echo password_hash($p, PASSWORD_DEFAULT);')

echo "Creating admin user $username into database..."

mysql -u root -h 127.0.0.1 -P 3306 --skip-ssl < ./databaseApi/database.sql
mysql -u root -h 127.0.0.1 -P 3306 --skip-ssl -e "INSERT INTO DBPortfolio.Users (Nome, Username, Email, Passwd, Role_user) VALUES ('$nome', '$username', '$email', '$hashed_password', 'Admin');"

echo "Admin user $username created successfully."

echo "Setup completed. You can now run the application with start.sh"

echo " ,----.                    ,--.,--.                  "
echo "'  .-./    ,---.  ,---.  ,-|  ||  |-.,--. ,--.,---.  "
echo "|  | .---.| .-. || .-. |' .-. || .-. '\\  '  /| .-. : "
echo "'  '--'  |' '-' '' '-' '\\ \`-' || \`-' | \\   ' \\   --. "
echo " \`------'  \`---'  \`---'  \`---'  \`---'.-'  /   \`----' "
echo "                                     \`---'           "