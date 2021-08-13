<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\BudgetService;

class Budget extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'budgets';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $appends = ['subtotal', 'iva', 'total'];
    
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getSubtotalAttribute()
    {   
        $subtotal = 0;
        $headings = json_decode($this->headings);
        foreach ($headings as $heading) {
            $subheadings = json_decode($heading->subheading);
            foreach ($subheadings as $subheading) {
                $qty = (int) $subheading->qty;
                $price = (int) $subheading->price;
                $subtotal += $qty * $price;
            }
        }
        
        return $subtotal;
    }
    
    public function getIvaAttribute()
    {           
        return $this->subtotal * 0.22;
    }

    public function getTotalAttribute()
    {           
        return $this->subtotal * 1.22;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
