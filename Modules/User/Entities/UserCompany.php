<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCompany extends Pivot
{
    protected $table = 'user_company_mapping'; // Tên của bảng trung gian

    protected $fillable = [
        'USER_ID', 'COMPANY_ID', // Tên các cột khóa ngoại trong bảng trung gian
    ];

    // Không cần thiết lập các timestamps (created_at và updated_at) cho bảng trung gian
    public $timestamps = false;

    public $incrementing = true;
}
