<?php

namespace App\Models;

use Database\Factories\ComandaItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['comanda_id', 'product_id', 'product_name', 'quantity', 'unit_price', 'unit_cost'])]
class ComandaItem extends Model
{
    /** @use HasFactory<ComandaItemFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function comanda(): BelongsTo
    {
        return $this->belongsTo(Comanda::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function subtotal(): float
    {
        return $this->quantity * (float) $this->unit_price;
    }
}
