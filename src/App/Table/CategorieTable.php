<?php
namespace App\Table;
use App\Database;
use App\App;


class CategorieTable extends Table{

    public function __construct() {
        $this->table = 'categories';
    }

    public function findCategory($categorie_id){
        return $this->query("SELECT * FROM  {$this->table} WHERE id = ?" , [$categorie_id], true );
    }
    public function insert($data){
        $req = $this->getPDO()->prepare("INSERT INTO {$this->table} (nom, type) VALUES(?, ?)");
        return $req->execute([$data['nom'], $data['type']]);
    }
    public function getTotalByCategorie(): array {
        $sql = "SELECT c.id, c.nom, c.type, COALESCE(SUM(t.montant), 0) as total FROM categories c
                LEFT JOIN transactions t ON t.categorie_id = c.id 
                GROUP BY c.id, c.nom, c.type";
        return $this->query($sql);       
    }
    public function update(int $id, array $data) : void{
        $sql = 'UPDATE categories SET nom = ?, type = ? WHERE id = ?';
        $this->query($sql, [$data['nom'], $data['type'], $id]);
    }
    public function delete(int $id){
        $sql = 'DELETE FROM categories WHERE id = ?';
        $this->query($sql, [$id]);
    }
}
