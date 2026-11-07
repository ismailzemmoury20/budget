<?php
namespace App;

/**
 * Petits outils d'affichage partagés par les vues.
 */
class Format
{
    private const MOIS = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

    /** 1234.5 → "1 234,50 €" (espaces insécables) ; $signed ajoute + ou − */
    public static function money($value, bool $signed = false): string
    {
        $value = (float) $value;
        $txt = number_format(abs($value), 2, ',', "\u{202F}") . "\u{00A0}€";
        if ($signed) {
            return ($value < 0 ? '−' : '+') . $txt;
        }
        return ($value < 0 ? '−' : '') . $txt;
    }

    /** Montant avec les centimes à part, pour les grands chiffres */
    public static function moneyParts($value): array
    {
        $value = (float) $value;
        $int = number_format(floor(abs($value)), 0, ',', "\u{202F}");
        $cents = str_pad((string) round((abs($value) - floor(abs($value))) * 100), 2, '0', STR_PAD_LEFT);
        return [($value < 0 ? '−' : '') . $int, ',' . $cents . "\u{00A0}€"];
    }

    public static function monthName(int $month): string
    {
        return self::MOIS[$month - 1];
    }

    /** "2026-11-07" → "7 nov." ; aujourd'hui / hier en toutes lettres */
    public static function shortDate(string $date): string
    {
        $ts = strtotime($date);
        if (date('Y-m-d', $ts) === date('Y-m-d')) return "Aujourd'hui";
        if (date('Y-m-d', $ts) === date('Y-m-d', strtotime('-1 day'))) return 'Hier';
        $abbr = ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin', 'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'];
        return (int) date('j', $ts) . ' ' . $abbr[(int) date('n', $ts) - 1];
    }

    /** Teinte stable par catégorie (pastel + encre de la même teinte) */
    public static function tint($categoryId): string
    {
        if ($categoryId === null || $categoryId === '') return 'tint-none';
        return 'tint-' . (((int) $categoryId - 1) % 6);
    }

    public static function initial(?string $name): string
    {
        $name = trim((string) $name);
        return $name === '' ? '–' : mb_strtoupper(mb_substr($name, 0, 1));
    }

    public static function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
