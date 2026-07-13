<?php
class FoodType {
    private string $typeName;

    public function __construct(string $typeName) {
        $this->typeName = $typeName;
    }

    public function getTypeName(): string {
        return $this->typeName;
    }
}