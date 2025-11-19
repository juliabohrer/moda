<?php

class DB
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'moda';
    private $port = '3306';

    private $table;
    private $pdo;

    public function __construct($table = null)
    {
        $this->table = $table ?? 'produtos'; // valor padrão: produtos
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
            return $pdo;

        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $fields = array_keys($data);
        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} (" . implode(',', $fields) . ")
                VALUES (" . str_repeat('?,', count($fields) - 1) . "?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function update($id, $data)
    {
        $fields = array_keys($data);
        $set = implode('=?, ', $fields) . '=?';

        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        $values = array_values($data);
        $values[] = $id;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
