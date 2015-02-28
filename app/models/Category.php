<?php namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    /**
     * Array of rules to validate against
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
    ];

    /**
     * A string of errors
     *
     * @var string
     */
    public $errors;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['title'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Gets the books that have the category
     *
     * @return books
     */
    public function books() 
    {
        return $this->belongsToMany('App\Models\Book');
    }

    /**
     * Validates inputen data against an array in the model
     *
     * @var data
     */
    public function isValid($data)
    {
        $validation = Validator::make($data, static::$rules);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }
}