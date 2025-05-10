<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compra #{{ $compra->id }} - YUSAR</title>
    <style>
        @page { margin: 20px; }
        body { font-family: 'Arial', sans-serif; color: #333; }
        .header { 
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 15px;
        }
        .logo { width: 120px; }
        .company-info { text-align: right; }
        .company-name { 
            color: #2c3e50; 
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .document-title {
            text-align: center;
            color: #2c3e50;
            margin: 15px 0;
            font-size: 20px;
        }
        .info-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .info-column { width: 48%; }
        .info-label { 
            font-weight: bold; 
            color: #4CAF50;
            margin-bottom: 5px;
        }
        .info-value { margin-bottom: 10px; }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #e8f5e9 !important;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .signature-area {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            text-align: center;
            padding-top: 5px;
        }
        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <!-- Encabezado con logo -->
    <div class="header">
        <div>
            <img src="{{ storage_path('app/public/logo_yusar.png') }}" class="logo" alt="YUSAR">
        </div>
        <div class="company-info">
            <h1 class="company-name">YUSAR</h1>
            <div>Tienda de materiales y confecciones</div>
            <div>La Paz, Bolivia</div>
        </div>
    </div>

    <!-- Título del documento -->
    <div class="document-title">
        REPORTE DE COMPRA #{{ $compra->id }}
    </div>

    <!-- Información de la compra -->
    <div class="info-box">
        <div class="info-column">
            <div class="info-label">INFORMACIÓN DEL PROVEEDOR</div>
            <div class="info-value"><strong>Nombre:</strong> {{ $compra->proveedor->nombre }}</div>
            <div class="info-value"><strong>Contacto:</strong> {{ $compra->proveedor->contacto }}</div>
            <div class="info-value"><strong>C.I./NIT:</strong> {{ $compra->proveedor->ci ?? 'N/A' }}</div>
            
            <div class="info-label" style="margin-top: 15px;">FECHA Y HORA</div>
            <div class="info-value"><strong>Emisión:</strong> {{ now()->setTimezone('America/La_Paz')->format('d/m/Y H:i') }} (La Paz)</div>
            <div class="info-value"><strong>Entrega estimada:</strong> {{ $compra->fecha_entrega_estimada->setTimezone('America/La_Paz')->format('d/m/Y') }}</div>
        </div>
        
        <div class="info-column">
            <div class="info-label">INFORMACIÓN DE LA COMPRA</div>
            <div class="info-value"><strong>Estado:</strong> <span style="color: #4CAF50; font-weight: bold;">{{ strtoupper($compra->estado) }}</span></div>
            <div class="info-value"><strong>Registrado por:</strong> {{ $compra->user->nombre }}</div>
            <div class="info-value"><strong>Código compra:</strong> YUS-COMP-{{ str_pad($compra->id, 5, '0', STR_PAD_LEFT) }}</div>
            
            <div class="info-label" style="margin-top: 15px;">DETALLES ADICIONALES</div>
            <div class="info-value"><strong>Almacén destino:</strong> {{ $compra->detalles->first()->inventarios->first()->almacen->nombre ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- Tabla de materiales -->
    <table class="table">
        <thead>
            <tr>
                <th width="40%">MATERIAL</th>
                <th width="15%">CANTIDAD</th>
                <th width="15%">PRECIO UNIT.</th>
                <th width="15%">SUBTOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compra->detalles as $detalle)
            <tr>
                <td>{{ $detalle->material->nombre }}</td>
                <td>{{ number_format($detalle->cantidad, 2) }} {{ $detalle->material->unidad_medida }}</td>
                <td>{{ number_format($detalle->precio_unitario, 2) }} Bs</td>
                <td>{{ number_format($detalle->precio_total, 2) }} Bs</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3"><strong>TOTAL COMPRA</strong></td>
                <td colspan="2"><strong>{{ number_format($compra->detalles->sum('precio_total'), 2) }} Bs</strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Área de firmas -->
    <div class="signature-area">
        <div class="signature-line">
            Responsable de Recepción
        </div>
        <br><br>
        <div class="signature-line">
            Responsable de Almacén
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <div>YUSAR - Tienda de materiales y confecciones</div>
        <div>La Paz, Bolivia • Teléfono: +591 XXX XXX XXX</div>
        <div>Página <span class="page-number"></span></div>
    </div>
</body>
</html>