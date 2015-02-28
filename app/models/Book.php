<?php namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {

    /**
     * Array of rules to validate against
     *
     * @var array
     */
    public static $rules = [
        'isbn' => 'required|unique:books',
        'title' => 'required'
    ];

    /**
     * Array of rules to validate against
     *
     * @var array
     */
    public static $rulesEdit = [
        'isbn' => 'required',
        'title' => 'required'
    ];

    /**
     * A string of errors
     *
     * @var string
     */
    public $errors;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['isbn', 'title', 'author', 'description', 'amount', 'imageUrl'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Gets the author that made the book
     *
     * @return books
     */
    public function authors() 
    {
        return $this->belongsToMany('App\Models\Author');
    }

    /**
     * Gets the categories that the book have
     *
     * @return books
     */
    public function categories() 
    {
        return $this->belongsToMany('App\Models\Category');
    }

    /**
     * Validates inputen data against an array in the model
     *
     * @var data
     */
    public function isValid($data, $edit = false)
    {
        $validation = $edit ? Validator::make($data, static::$rulesEdit): Validator::make($data, static::$rules);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }
}