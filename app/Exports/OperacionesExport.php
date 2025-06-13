<?php

namespace App\Exports;

use App\Models\Operacion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;


class OperacionesExport implements FromQuery, WithHeadings
{
    protected $filters;
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Operacion::with('usuario')->orderBy('fecha_hora', 'desc');

        if (!empty($this->filters['tipo'])) {
            $query->where('tipo', $this->filters['tipo']);
        }
        if (!empty($this->filters['entidad'])) {
            $query->where('entidad', $this->filters['entidad']);
        }
        if (!empty($this->filters['search'])) {
            $query->where('descripcion', 'like', '%' . $this->filters['search'] . '%');
        }
        if (!empty($this->filters['usuario_id'])) {
            $query->where('usuario_id', $this->filters['usuario_id']);
        }

        return $query->select([
            'operacion_id',
            'tipo',
            'entidad',
            'entidad_id',
            'descripcion',
            'cantidad',
            'fecha_hora',
            'usuario_id',
            'ip',
            'user_agent',
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tipo',
            'Entidad',
            'ID Entidad',
            'Descripción',
            'Cantidad',
            'Fecha y hora',
            'Usuario ID',
            'IP',
            'User Agent',
        ];
    }
}
