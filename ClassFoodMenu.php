<?php
class FoodMenu {
    private string $name;

    // Constructor สำหรับใส่ข้อมูลตอนสร้าง Object
    public function __construct(string $name) {
        $this->name = $name;
    }

    // Method (ฟังก์ชัน) สำหรับดึงชื่อเมนูออกไปแสดงผล
    public function getName(): string {
        return $this->name;
    }
}