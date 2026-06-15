<?php

class dbConnect {
    private $host = "127.0.0.1";
    private $port = 3306;
    private $user = "root";
    private $password = "";
    private $dbName = "DBPortfolio";
    private $conn;


    function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName};port={$this->port}", 
                $this->user, 
                $this->password,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"]
                );

            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function loginUserByEmail($email, $passwd): array | bool{
        try {
            $query = $this->conn->prepare("SELECT Email, Nome, Username, Passwd, Role_user, id FROM Users WHERE Email = :email;");
            $ex = $query->execute(
                [
                    ":email" => $email
                ]
            );

            if ($ex) {
                $user = $query->fetch(PDO::FETCH_ASSOC);

                if (password_verify($passwd, $user["Passwd"])) {
                    return [
                        "Nome" => $user["Nome"] ?? null,
                        "Username" => $user["Username"] ?? null,
                        "Email" => $user["Email"] ?? null,
                        "Role" => $user["Role_user"] ?? null,
                        "id" => $user["id"] ?? null
                    ];
                }
            }
        }
        catch (Exception $e) {
            return false;
        }

        return false;
    }

    public function registerUser($nome, $username, $email, $passwd): bool {
        try {
            $query = $this->conn->prepare("INSERT INTO Users (Nome, Username, Email, Passwd) VALUES (:nome, :username, :email, :passwd);");
            $ex = $query->execute(
                [
                    ":nome" => $nome ?? null,
                    ":username" => $username ?? null,
                    ":email" => $email ?? null,
                    ":passwd" => $passwd ?? null
                ]
            );

            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }


        return false;
    }

    public function getAllPostsDESC(): bool | array {
        try {
            $query = $this->conn->query("SELECT P.*, U.Nome, U.Username FROM Posts P JOIN Users U ON U.id = P.idUser ORDER BY P.dataPublicazione DESC LIMIT 5;");

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

        public function getAllPosts(): bool | array {
        try {
            $query = $this->conn->query("SELECT P.*, U.Nome, U.Username FROM Posts P JOIN Users U ON U.id = P.idUser;");

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getPostFromId($id): bool | array {
        try {
            $query = $this->conn->prepare("SELECT P.*, U.Nome, U.Username FROM Posts P JOIN Users U ON U.id = P.idUser where P.id = :id;");
            $ex = $query->execute(
                [
                ":id" => $id ?? null
                ]
            );
            if ($ex) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getCountPosts() {
        try {
            $query = $this->conn->query("SELECT COUNT(P.id) as tot FROM Posts P;");
            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function getCountUsers() {
        try {
            $query = $this->conn->query("SELECT COUNT(U.id) as tot FROM Users U;");
            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function getCountUsersAdmin() {
        try {
            $query = $this->conn->query("SELECT COUNT(U.id) as tot FROM Users U WHERE U.Role_user = \"Admin\";");
            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function searchPosts($title) {
        try {
            $query = $this->conn->prepare("SELECT P.* FROM Posts P WHERE P.Titolo LIKE :title;");
            $ex = $query->execute(
                [
                ":title" => "%" . $title . "%" ?? null
                ]
            );
            if ($ex) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getAllCategoria() {
        try {
            $query = $this->conn->query("SELECT C.idCat AS id, C.Nome FROM Categoria C;");

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getCountCategoria() {
        try {
            $query = $this->conn->query("SELECT COUNT(C.idCat) as tot FROM Categoria C;");

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getCatIdByName($nome) {
        try {
            $query = $this->conn->prepare("SELECT C.idCat FROM Categoria C WHERE C.Nome = :nome");
            $ex = $query->execute(
                [
                ":nome" => $nome ?? null
                ]
            );
            if ($ex) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getNameCatById($id) {
        try {
            $query = $this->conn->prepare("SELECT C.Nome FROM Categoria C WHERE C.idCat = :id");
            $ex = $query->execute(
                [
                ":id" => $id ?? null
                ]
            );
            if ($ex) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function createPosts($titolo, $dataPublicazione, $contenuto, $estratto, $idUser, $idCat): bool {
        try {
            $query = $this->conn->prepare("INSERT INTO Posts (Titolo, dataPublicazione, Contenuto, ContenutoEstratto, idUser, idCat) VALUES (:titolo, :dataPublicazione, :contenuto, :estratto, :idUser, :idCat);");
            $ex = $query->execute(
                [
                    "titolo" => $titolo ?? null,
                    "dataPublicazione" => $dataPublicazione ?? null,
                    "contenuto" => $contenuto ?? null,
                    "estratto" => $estratto ?? null,
                    "idUser" => $idUser ?? null,
                    "idCat" => $idCat ?? null
                ]
            );

            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function createCat($nome) {
        try {
            $query = $this->conn->prepare("INSERT INTO Categoria (Nome) VALUES (:nome);");
            $ex = $query->execute(
                [
                    "nome" => $nome ?? null
                ]
            );

            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function deleteCat($id) {
        try {
            $query = $this->conn->prepare("DELETE FROM Categoria WHERE idCat = :id;");
            $ex = $query->execute(
                [
                    "id" => $id ?? null
                ]
            );
            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function deletePost($id) {
        try {
            $query = $this->conn->prepare("DELETE FROM Posts WHERE id = :id;");
            $ex = $query->execute(
                [
                    "id" => $id ?? null
                ]
            );
            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getAllUser() {
        try {
            $query = $this->conn->query("SELECT U.id, U.Nome, U.Username, U.Email, U.Role_user FROM Users U;");

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function deleteUserById($id) {
        try {
            $query = $this->conn->prepare("DELETE FROM Users WHERE id = :id;");
            $ex = $query->execute(
                [
                    "id" => $id ?? null
                ]
            );
            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getAdminUsers() {
        try {
            $query = $this->conn->query("SELECT U.id, U.Nome, U.Username, U.Email, U.Role_user FROM Users U WHERE U.Role_user = \"Admin\";");

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function createProject($nome, $stato, $idCat, $link, $tecnologie, $descrizione, $idUser, $DataCreazione): bool {
        try {
            $query = $this->conn->prepare("INSERT INTO Progetti(Nome, Descrizione, DataCreazione, link, stato, idCat, tecnologie, idUser) VALUES (:nome, :descrizione, :DataCreazione, :link, :stato, :idCat, :tecnologie, :idUser);");
            $ex = $query->execute(
                [
                    "nome" => $nome ?? null,
                    "descrizione" => $descrizione ?? null,
                    "DataCreazione" => $DataCreazione ?? null,
                    "link" => $link ?? null,
                    "stato" => $stato ?? null,
                    "idCat" => $idCat ?? null,
                    "tecnologie" => $tecnologie,
                    "idUser" => $idUser ?? null
                ]
            );

            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getAllProgetti() {
        try {
            $query = $this->conn->query("SELECT P.*, C.Nome as Categoria, U.Username FROM Progetti P JOIN Users U ON U.id = P.idUser JOIN Categoria C ON C.idCat = P.idCat;");

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function getAllProject() {
        try {
            $query = $this->conn->query("SELECT P.*, C.Nome as Categoria, U.Username FROM Progetti P JOIN Users U ON U.id = P.idUser JOIN Categoria C ON C.idCat = P.idCat;");

            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function deleteProjectById($id) {
        try {
            $query = $this->conn->prepare("DELETE FROM Progetti WHERE id = :id;");
            $ex = $query->execute(
                [
                    "id" => $id ?? null
                ]
            );
            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function addAdminUserByEmail($email) {
        try {
            $query = $this->conn->prepare("UPDATE Users SET Role_user = \"Admin\" WHERE Email = :email;");
            $ex = $query->execute(
                [
                    "email" => $email ?? null
                ]
            );
            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function countProgetti() {
        try {
            $query = $this->conn->query("SELECT COUNT(P.id) as tot FROM Progetti P;");
            if ($query) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function getProjectFromId($id) {
        try {
            $query = $this->conn->prepare("SELECT P.*, C.Nome as Categoria, U.Username FROM Progetti P JOIN Users U ON U.id = P.idUser JOIN Categoria C ON C.idCat = P.idCat WHERE P.id = :id;");
            $ex = $query->execute(
                [
                ":id" => $id ?? null
                ]
            );
            if ($ex) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function updatePost($id, $titolo, $contenuto, $estratto, $idCat) {
        try {
            $query = $this->conn->prepare("UPDATE Posts SET Titolo = :titolo, Contenuto = :contenuto, ContenutoEstratto = :estratto, idCat = :idCat WHERE id = :id;");
            $ex = $query->execute(
                [
                    "id" => $id ?? null,
                    "titolo" => $titolo ?? null,
                    "contenuto" => $contenuto ?? null,
                    "estratto" => $estratto ?? null,
                    "idCat" => $idCat ?? null
                ]
            );

            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function updateUser($id, $nome, $username, $estratto, $idCat) {
        try {
            $query = $this->conn->prepare("UPDATE Posts SET Titolo = :titolo, Contenuto = :contenuto, ContenutoEstratto = :estratto, idCat = :idCat WHERE id = :id;");
            $ex = $query->execute(
                [
                    "id" => $id ?? null,
                    "titolo" => $titolo ?? null,
                    "contenuto" => $contenuto ?? null,
                    "estratto" => $estratto ?? null,
                    "idCat" => $idCat ?? null
                ]
            );

            if ($ex) {
                return true;
            }
        }
        catch (Exception $e) {
            return false;
        }
        return false;
    }
}
?>