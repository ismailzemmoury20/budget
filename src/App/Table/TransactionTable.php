<?php
namespace App\Table;
use App\Database;
use App\App;

class TransactionTable extends Table{

    public function __construct() {
        $this->table = 'transactions';
    }

    public function getTransactionsByMonth($month, $year, $user_id): array {
        return $this->query("SELECT * FROM {$this->table} WHERE MONTH(date) = ? AND YEAR(date) = ? AND user_id = ?", [$month, $year, $user_id]);
    }
    public function insert($data){
        $req = $this->getPDO()->prepare("INSERT INTO {$this->table} (montant, description, type, categorie_id, date, notes, user_id) VALUES(?, ?, ?, ?, ?, ?, ?)");
        return $req->execute([$data['montant'], $data['description'], $data['type'], $data['categorie_id'], $data['date'], $data['notes'], $data['user_id']]);
    }
    public function getTotalRevenu($user_id){
        return $this->query("SELECT SUM(montant) as total FROM {$this->table} WHERE type = ? AND user_id = ?", ['revenu', $user_id], true);
    }
    public function getTotalDepense($user_id){
        return $this->query("SELECT SUM(montant) as total FROM {$this->table} WHERE type = ? AND user_id = ?", ['depense', $user_id], true);
    }
    public function getSold($user_id){
        $revenu = $this->getTotalRevenu($user_id)->total ?? 0;
        $depense = $this->getTotalDepense($user_id)->total ?? 0;
        return $revenu - $depense;
    }
    public function getLastTransaction($user_id): array {
        return $this->query("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY date DESC LIMIT 10", [$user_id]);
    }
    public function findAllWithCategory($user_id): array {
        return $this->query(
            "SELECT t.*, COALESCE(c.nom, 'Sans catégorie') AS categorie_nom
             FROM {$this->table} t
             LEFT JOIN categories c ON c.id = t.categorie_id
             WHERE t.user_id = ?
             ORDER BY t.date DESC",
            [$user_id]
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
