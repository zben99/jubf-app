<?php

namespace App\Services;

use ZipArchive;

class XlsxWriter
{
    private array $sheets = [];

    public function addSheet(string $name, array $rows): void
    {
        // Excel sheet name: max 31 chars, strip forbidden chars
        $name = preg_replace('/[\\\\\/\?\*\[\]:]/', '', $name);
        $name = mb_substr($name ?: 'Feuille', 0, 31);

        $this->sheets[] = ['name' => $name, 'rows' => $rows];
    }

    public function download(string $filename): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_') . '.xlsx';
        $this->writeTo($tmpFile);

        return response()->streamDownload(function () use ($tmpFile) {
            readfile($tmpFile);
            @unlink($tmpFile);
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function writeTo(string $path): void
    {
        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $count = count($this->sheets);

        $zip->addFromString('[Content_Types].xml',      $this->contentTypes($count));
        $zip->addFromString('_rels/.rels',              $this->rootRels());
        $zip->addFromString('xl/workbook.xml',          $this->workbook());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRels($count));
        $zip->addFromString('xl/styles.xml',            $this->styles());

        foreach ($this->sheets as $i => $sheet) {
            $zip->addFromString("xl/worksheets/sheet{$i}.xml", $this->sheet($sheet['rows']));
        }

        $zip->close();
    }

    // ── XML builders ─────────────────────────────────────────────────────────

    private function contentTypes(int $n): string
    {
        $overrides = '';
        for ($i = 0; $i < $n; $i++) {
            $overrides .= "<Override PartName=\"/xl/worksheets/sheet{$i}.xml\""
                . " ContentType=\"application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml\"/>";
        }
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . $overrides
            . '</Types>';
    }

    private function rootRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    private function workbook(): string
    {
        $sheets = '';
        foreach ($this->sheets as $i => $sheet) {
            $name  = htmlspecialchars($sheet['name'], ENT_XML1, 'UTF-8');
            $rId   = $i + 1;
            $sheets .= "<sheet name=\"{$name}\" sheetId=\"{$rId}\" r:id=\"rId{$rId}\"/>";
        }
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"'
            . ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets>' . $sheets . '</sheets>'
            . '</workbook>';
    }

    private function workbookRels(int $n): string
    {
        $rels = '';
        for ($i = 0; $i < $n; $i++) {
            $rId = $i + 1;
            $rels .= "<Relationship Id=\"rId{$rId}\""
                . " Type=\"http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet\""
                . " Target=\"worksheets/sheet{$i}.xml\"/>";
        }
        $rels .= '<Relationship Id="rIdStyles"'
            . ' Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles"'
            . ' Target="styles.xml"/>';
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . $rels
            . '</Relationships>';
    }

    private function styles(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="2">'
            . '<font><sz val="11"/><name val="Calibri"/></font>'             // 0 = normal
            . '<font><b/><sz val="11"/><name val="Calibri"/></font>'         // 1 = bold
            . '</fonts>'
            . '<fills count="2">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '</fills>'
            . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="2">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'  // s=0 normal
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0"/>'  // s=1 bold
            . '</cellXfs>'
            . '</styleSheet>';
    }

    private function sheet(array $rows): string
    {
        $colLetters = range('A', 'Z');

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetData>';

        foreach ($rows as $rowIdx => $row) {
            $rowNum = $rowIdx + 1;
            $xml .= "<row r=\"{$rowNum}\">";

            foreach ($row as $colIdx => $cell) {
                $col     = $colLetters[$colIdx] ?? 'A';
                $cellRef = $col . $rowNum;
                $bold    = false;

                if (is_array($cell) && array_key_exists('value', $cell)) {
                    $bold = !empty($cell['bold']);
                    $cell = $cell['value'];
                }

                $style = $bold ? ' s="1"' : '';

                if (is_numeric($cell) && !is_string($cell)) {
                    $xml .= "<c r=\"{$cellRef}\"{$style}><v>{$cell}</v></c>";
                } else {
                    $val  = htmlspecialchars((string) $cell, ENT_XML1, 'UTF-8');
                    $xml .= "<c r=\"{$cellRef}\" t=\"inlineStr\"{$style}><is><t>{$val}</t></is></c>";
                }
            }

            $xml .= '</row>';
        }

        $xml .= '</sheetData></worksheet>';
        return $xml;
    }
}
