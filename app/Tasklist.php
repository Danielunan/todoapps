<?php namespace App;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class Tasklist extends Model {

    //mass assignable fields
    protected $fillable=['title','slug'];

    # date created accessor
    public function getCreatedAtAttribute(){

        return Helpers::custom_date_format(env('SITE_DATEFORMAT'),$this->attributes['created_at']);
    }

    # date updated accessor
    public function getUpdatedAtAttribute(){

        return Helpers::custom_date_format(env('SITE_DATEFORMAT'),$this->attributes['updated_at']);
    }

    # pagination scope
    public function scopeCustompaginate($query){
        return $query->paginate(env('PAGINATION_LIMIT'));
    }

    # a tasklist has many tasks
    public function tasks(){
        return $this->hasMany('App\Task')->orderBy('id','desc');
    }

}
