<?php
namespace App\Table;

class UserTable extends Table {

    public function __construct() {
        $this->table = 'users';
    }

    public function getByUsername(string $username) {
        return $this->query(
            "SELECT * FROM users WHERE email = ?", [$username], true);
    }

    public function setInfosRegister(array $data): void {
        $req = $this->getPDO()->prepare(
            "INSERT INTO users (nom, prenom, email, password) VALUES (?, ?, ?, ?)"
        );
        $req->execute([$data['nom'], $data['prenom'], $data['email'], $data['password']]);
    }
}
