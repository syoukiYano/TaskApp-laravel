<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{    
    const STATUS =[
        1 => ['label'=>'今やってるよ!','class'=>'badge-info'],
        2 => ['label'=>'ちょ待ち','class'=>'badge-danger'],                
        3 => ['label'=>'Zzz..','class'=>'badge-secondary'],    
        4 => ['label'=>'終わり!','class'=>'badge-primary'],    
    ];
    //アクセサ get'SampleTest'Attribute()は必須 'SampleTest'はキャメルケースで参照時はスネーク {{ $task->sample_test }}
    public function getStatusLabelAttribute(){
        $status = $this->attributes['status'];//Statusの値を取得
        if(!isset(self::STATUS[$status])){    //nullだったらreturn
            return '';
        }        
        return self::STATUS[$status]['label']; //STATUS配列から取得
    }
    public function getStatusClassAttribute(){
        $status = $this->attributes['status'];
        if(!isset(self::STATUS[$status])){
            return '';
        }
        return self::STATUS[$status]['class'];
    }
    public function getFormattedDueDateAttribute(){
        return Carbon::createFromFormat('Y-m-d',$this->attributes['due_date'])->format('Y/m/d');
    }

    

}
