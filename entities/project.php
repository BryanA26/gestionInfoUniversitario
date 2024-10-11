<?php

class Project {

    private int $idProyecto;
    private string $titulo;
    private string $resumen;
    private float $presupuesto;
    private string $tipoFinanciacion;
    private string $tipoFondos;
    private $fechaInicio;
    private $fechaFin;

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