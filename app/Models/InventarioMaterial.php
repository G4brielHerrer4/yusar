<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventarioMaterial extends Model
{

    protected $table = 'inventario_materiales';
    protected $fillable = [
        'material_id',
        'almacen_id',
        'detalle_compra_id',
        'stock_actual'
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
    

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class);

    }
    public function detalleCompra(): BelongsTo
    {
        return $this->belongsTo(DetalleCompra::class);
    }

    public function configuracionCEP() 
    {
        return $this->hasOne(ConfiguracionCEP::class, 'inventario_material_id');
    }

    // Actualizar stock al asignar materiales
    public function reducirStock(float $cantidad): bool
    {
        $this->stock_actual -= $cantidad;
        return $this->save();
    }
}