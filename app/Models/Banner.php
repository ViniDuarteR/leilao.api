<?php
/*
|--------------------------------------------------------------------------
| Informações do Arquivo
|--------------------------------------------------------------------------
|
| Projeto: Leiloeira Fernanda Freire
| Autor: Vinicius Duarte
| Email: viniciusduarterosa@icloud.com
| Data: Junho de 2025
|
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'link_url',
        'is_active',
        'display_order',
    ];
}
