<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;
    protected $table = 'complains';
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'nid',
        'email',
        'organization_name',
        'product_name',
        'product_photo',
        'invoice_photo',
        'department',
        'subDepartment',
        'subject',
        'description',
        'case_no',
        'result_date',
        'case_status',
        'apply_date',
        'hearing_date',
        'district_id',
        'division_id',
    ];
}
