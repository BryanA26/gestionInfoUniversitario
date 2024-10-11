<?php

class TypeProduct
{
    private int $idTipoProducto;
    private string $categoria;
    private string $clase;
    private string $nombre;
    private string $tipologia;
    
    public function __construct(string $categoria,string $clase,string $nombre,string $tipologia)
    {
        $this->categoria = $categoria;
        $this->clase = $clase;
        $this->nombre = $nombre;
        $this->tipologia = $tipologia;
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