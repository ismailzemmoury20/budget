<?php
namespace App\Table;
use App\Database;
use App\App;

class TransactionTable extends Table{
    public  function getTransactionsByMonth($month, $year){
       return $this->query("SELECT * FROM {$this->table} WHERE MONTH(date) = ? AND YEAR(date) = ?", [$month, $year]);
    }
    public function insert($data){
        $req = $this->getPDO()->prepare("INSERT INTO {$this->table} (montant, description, type, categorie_id, date, notes) VALUES(?, ?, ?, ?, ?, ?)");
        return $req->execute([$data['montant'], $data['description'], $data['type'], $data['categorie_id'], $data['date'], $data['notes']]);
    }
    public function getTotalRevenu(){
        return $this->query("SELECT SUM(montant) as total FROM {$this->table} WHERE type = ?", ['revenu'], true);
    }
    public function getTotalDepense(){
        return $this->query("SELECT SUM(montant) as total FROM {$this->table} WHERE type = ?", ['depense'], true);
    }
    public function getSold(){
        $revenu = $this->getTotalRevenu()->total;
        $depense = $this->getTotalDepense()->total;
        return $revenu - $depense;
    }
    public function getLastTransaction(): array{
        return $this->query("SELECT * FROM {$this->table} ORDER BY date DESC LIMIT 10");
    }
    public function findAllWithCategory(): array {
        return $this->query(
            "SELECT t.*, COALESCE(c.nom, 'Sans catégorie') AS categorie_nom
             FROM {$this->table} t
             LEFT JOIN categorie c ON c.id = t.categorie_id
             ORDER BY t.date DESC"
        );
    }

    public function toCsvFile(array $array){
        if(count($array) == 0){
            return null;
        }
        ob_start();
        $df = fopen("php://output", "w");
        // BOM UTF-8 pour compatibilité Excel
        fputs($df, "\xEF\xBB\xBF");
        fputcsv($df, ['ID', 'Montant (€)', 'Description', 'Type', 'Catégorie', 'Date', 'Notes'], ';');
        foreach($array as $row){
            $type = $row->type === 'revenu' ? 'Revenu' : 'Dépense';
            $categorie = isset($row->categorie_nom) ? $row->categorie_nom : ($row->categorie_id ?? '-');
            fputcsv($df, [
                $row->id,
                number_format($row->montant, 2, ',', ''),
                $row->description,
                $type,
                $categorie,
                date('d/m/Y', strtotime($row->date)),
                $row->notes ?? ''
            ], ';');
        }
        fclose($df);
        return ob_get_clean();
    }
}
