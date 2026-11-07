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

    /**
     * Tout ce qu'il faut pour afficher un mois : totaux, reste, dépenses par jour et par catégorie.
     * Les totaux sont calculés à partir des lignes, jamais saisis à part.
     */
    public function monthSummary(int $year, int $month): array {
        $rows = $this->query(
            "SELECT t.*, c.nom AS categorie_nom FROM {$this->table} t
             LEFT JOIN categorie c ON c.id = t.categorie_id
             WHERE YEAR(t.date) = ? AND MONTH(t.date) = ?
             ORDER BY t.date DESC, t.id DESC", [$year, $month]);
        $daysInMonth = (int) date('t', mktime(0, 0, 0, $month, 1, $year));
        $perDay = array_fill(1, $daysInMonth, 0.0);
        $perCategory = [];
        $income = 0.0; $expense = 0.0;
        foreach ($rows as $r) {
            $amount = round((float) $r->montant, 2);
            if ($r->type === 'revenu') {
                $income += $amount;
            } else {
                $expense += $amount;
                $perDay[(int) date('j', strtotime($r->date))] += $amount;
                $key = $r->categorie_id ?? 0;
                if (!isset($perCategory[$key])) {
                    $perCategory[$key] = ['id' => $r->categorie_id, 'nom' => $r->categorie_nom ?? 'Sans catégorie', 'total' => 0.0, 'count' => 0];
                }
                $perCategory[$key]['total'] += $amount;
                $perCategory[$key]['count']++;
            }
        }
        usort($perCategory, fn($a, $b) => $b['total'] <=> $a['total']);
        return [
            'year' => $year, 'month' => $month, 'days' => $daysInMonth,
            'rows' => $rows,
            'income' => round($income, 2),
            'expense' => round($expense, 2),
            'left' => round($income - $expense, 2),
            'perDay' => $perDay,
            'perCategory' => $perCategory,
        ];
    }

    public function update(int $id, array $data): void {
        $req = $this->getPDO()->prepare("UPDATE {$this->table} SET montant = ?, description = ?, type = ?, date = ? WHERE id = ?");
        $req->execute([$data['montant'], $data['description'], $data['type'], $data['date'], $id]);
    }
    public function delete(int $id): void {
        $req = $this->getPDO()->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $req->execute([$id]);
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
