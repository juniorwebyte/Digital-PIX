<?php

namespace App;

use App\Models\Participante;
use Illuminate\Database\Eloquent\Model;

class Payment_pix extends Model
{
    protected $table = 'payment_pix';

    protected $fillable = [
        'key_pix', 'participant_id',
    ];

    public function participante()
    {
        return $this->hasOne(Participante::class, 'id', 'participant_id')->first();
    }
}
