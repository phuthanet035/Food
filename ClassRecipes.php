<?php
class Recipes {
    private array $materials;
    private array $units;

    public function __construct(string $rawMaterialText, string $unitText) {
        // แตกข้อความแปลงเป็น Array ตั้งแต่ขั้นตอนการสร้าง Object เลย
        $this->materials = explode(', ', $rawMaterialText);
        $this->units = explode(', ', $unitText);
    }

    public function getMaterials(): array {
        return $this->materials;
    }

    public function getUnits(): array {
        return $this->units;
    }
}