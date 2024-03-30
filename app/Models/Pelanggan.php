<?php

namespace App\Models;

use CodeIgniter\Model;

class Pelanggan extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'kdplg';
    protected $protectFields    = true;
    protected $allowedFields    = ['kdplg','namaplg','alamat','nohp'];
}
