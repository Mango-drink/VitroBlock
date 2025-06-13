<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bitácora de Operaciones</title>
    <style>
        body { font-family: Arial, sans-serif; color: #1a202c; }
        .header { width: 100%; display: table; margin-bottom: 20px; border-bottom: 2px solid #4682B4;}
        .logo-cell { width: 90px; }
        .logo { height: 60px; }
        .title-block { padding-left: 12px; }
        .main-title { font-size: 1.7em; font-weight: bold; color: #4682B4; margin-bottom: 2px; }
        .subtitle { font-size: 1em; color: #444; }
        .meta { font-size: 0.95em; color: #555; }
        .table-block { margin-top: 20px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #a0aec0; padding: 6px 4px; font-size: 12px; }
        th { background: #4682B4; color: #fff; font-weight: bold; }
        tr:nth-child(even) { background: #f4f8fb; }
        tr:nth-child(odd)  { background: #fff; }
        .footer { margin-top: 32px; font-size: 11px; color: #888; text-align: right;}
    </style>
</head>
<body>
    <div class="header">
        <table width="100%" style="border:none;">
            <tr>
                <td class="logo-cell" style="border:none;">
                    <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" class="logo" />
                </td>
                <td style="border:none;">
                    <div class="title-block">
                        <div class="main-title">Bitácora de Operaciones</div>
                        <div class="subtitle">VitroBlocks | Reporte de Auditoría</div>
                        <div class="meta">Generado el {{ now()->format('d/m/Y H:i') }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="table-block">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Entidad</th>
                    <th>ID Entidad</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Fecha y hora</th>
                    <th>Usuario</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operaciones as $op)
                <tr>
                    <td>{{ $op->operacion_id }}</td>
                    <td>{{ ucfirst($op->tipo) }}</td>
                    <td>{{ ucfirst($op->entidad) }}</td>
                    <td>{{ $op->entidad_id }}</td>
                    <td>{{ $op->descripcion }}</td>
                    <td>{{ $op->cantidad }}</td>
                    <td>{{ $op->fecha_hora }}</td>
                    <td>{{ $op->usuario->nombre ?? $op->usuario_id }}</td>
                    <td>{{ $op->ip }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="footer">
        Reporte confidencial. Sólo para uso interno de VitroBlocks. &copy; {{ date('Y') }}
    </div>
</body>
</html>
