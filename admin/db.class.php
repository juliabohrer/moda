<?php

class DB
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'moda';
    private $port = '3306';

    private $table;
    public $pdo;

    public function __construct($table = null)
    {
        $this->table = $table; 
        $this->pdo = $this->connect();
    }

 
    public function connect()
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};port={$this->port};charset=utf8",
                $this->user,
                $this->password
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            return $pdo;

        } catch (PDOException $e) {
            die("Erro de conexão com o banco: " . $e->getMessage());
        }
    }

  
    public function login($login, $senha)
    {
        try {
            $sql = "SELECT * FROM usuario 
                    WHERE login = :login 
                    AND senha = :senha 
                    LIMIT 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':senha', $senha);
            $stmt->execute();

            return $stmt->fetch();

        } catch (PDOException $e) {
            echo "Erro no login: " . $e->getMessage();
            return false;
        }
    }

    public function find($id)
    {
        if (!$this->table) {
            die("Tabela não definida no DB");
        }

        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    
    public function findAll()
    {
        if (!$this->table) {
            die("Tabela não definida no DB");
        }

        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

   
    public function insert($data)
    {
        if (!$this->table) {
            die("Tabela não definida no DB");
        }

        $fields = array_keys($data);
        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} (" . implode(",", $fields) . ") 
                VALUES (" . str_repeat("?,", count($fields) - 1) . "?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    
    public function update($id, $data)
    {
        if (!$this->table) {
            die("Tabela não definida no DB");
        }

        $fields = array_keys($data);
        $set = implode("=?, ", $fields) . "=?";

        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        $values = array_values($data);
        $values[] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete($id)
    {
        if (!$this->table) {
            die("Tabela não definida no DB");
        }

        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
