<?php
namespace App\Table;

class UserTable extends Table {

    public function getByUsername(string $username) {
        return $this->query(
            "SELECT * FROM user WHERE email = ?", [$username], true);
    }

    public function setInfosRegister(array $data): void {
        $req = $this->getPDO()->prepare(
            "INSERT INTO user (username, email, password) VALUES (?, ?, ?)"
        );
        $req->execute([$data['username'], $data['email'], $data['password']]);
    }
}
