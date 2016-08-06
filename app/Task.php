<?php namespace App;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {

	//mass assignable fields
    protected $fillable=['title','tasklist_id','duedate','status'];


    # date created accessor
    public function getCreatedAtAttribute(){

        return Helpers::custom_date_format(env('SITE_DATEFORMAT'),$this->attributes['created_at']);
    }

    #publishDate mutator
    public function setDuedateAttribute($value){
        if($value){
            $this->attributes['duedate']=Helpers::database_ready_format($value);

        }

    }

    # publish date at accessor
    public function getDuedateAttribute(){

        if($this->attributes['duedate']){
            return Helpers::custom_date_format(env('SITE_DATEPICKERFORMAT'),$this->attributes['duedate']);
        }


    }

    # date updated accessor
    public function getUpdatedAtAttribute(){

        return Helpers::custom_date_format(env('SITE_DATEFORMAT'),$this->attributes['updated_at']);
    }

    # pagination scope
    public function scopeCustompaginate($query){
        return $query->paginate(env('PAGINATION_LIMIT'));
    }

    # a task belongs to one tasklist
    public function tasklist(){
        return $this->belongsTo('App\Tasklist');
    }

    # get by status
    public function scopeStatus($query,$status='active',$take='')
    {
        if($take){
            return $query->whereStatus(strtoupper($status))->take($take);
        }else{
            return $query->whereStatus(strtoupper($status))->paginate(env('PAGINATION_LIMIT'));
        }

    }

    # task search
    public static function search_for_task($title){
        if(strtolower($title)=='all'){
            $results = Task::with('tasklist')->orderBy('duedate','desc')->get();
        }else{
            $results = Task::with('tasklist')
                ->Where('title','LIKE','%'.$title.'%')
                ->orderBy('duedate','desc')->get();
        }



        return  $results;

    }

}
