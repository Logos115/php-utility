<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services'; // Make sure this matches your table name

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'rowid'; // Since your primary key is 'rowid'

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'services', // This matches your column name
        // Add other columns if needed
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true; // You have created_at and updated_at columns

    /**
     * Get the service name.
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->services; // Access the 'services' column as 'name'
    }
}