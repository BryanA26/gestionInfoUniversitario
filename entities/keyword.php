<?php

class Keyword {
    private string $termino;
    private string $terminoIngles;

    public function __construct(string $termino, string $terminoIngles)
    {
        $this->termino = $termino;
        $this->terminoIngles = $terminoIngles;
    }

    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new InvalidArgumentException("Propiedad no válida: $property");
    }

    public function __set(string $property, $value): void
    {
        if (property_exists($this, $property)) {
            // Agregar validación si es necesario
            $this->$property = $value;
        } else {
            throw new InvalidArgumentException("Propiedad no válida: $property");
        }
    }
}