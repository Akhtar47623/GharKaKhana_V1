<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use carbon\carbon;
class Schedule extends Model
{
    use SoftDeletes;
    protected $table = "menu_schedule";
    protected $primaryKey = "id";

    protected $guarded = ['id'];

    public static function sch($menu_id)
    {
     	$sch = self::where('menu_id',$menu_id)->first();
     	
                    if(!empty($sch)){
                    	$day=[];
                        if($sch->mon=="1"){
                        	array_push($day,1);
                            
                        }
                        if($sch->tue=="1"){
                        	array_push($day,2);
                            
                        }
                        if($sch->wed=="1"){
                        	array_push($day,3);
                            
                        }
                        if($sch->thu=="1"){
                        	array_push($day,4);
                            
                        }
                        if($sch->fri=="1"){
                        	array_push($day,5);
                            
                        }
                        if($sch->sat=="1"){
                        	array_push($day,6);
                            
                        }
                        if($sch->sun=="1"){
                        	array_push($day,0);
                            
                        }  
                                  
                        $startdate = Carbon::now()->addDay($sch->lead_time);
                        
                        if( $sch->recurring==1)
                        {                                
                            for($i=1;$i<=14;$i++){                            	                   
                                if(in_array($startdate->dayOfWeek, $day)){
                                	$date=$startdate;
          							break;                                 
                                }
                                $startdate=$startdate->addDay(1);
                            }                                           
                        }else{                                       
                            for($i=1;$i<=7;$i++){                    
                                if(in_array($startdate->dayOfWeek, $day)){
          							$date=$startdate;
 									break;                                     
                                }
                                $startdate=$startdate->addDay(1);
                            }
                        }
                        if($date->isToday()){
                            return "Today";
                        }else{
                        	$d = strtotime($startdate); 							
                            return $date=date('M j, Y ', $d);
                        } 
                        return $date;
                        
                    }
        
    }
    public static function allPermission()
    {
        $permissionList = self::permissionList();

        $action = self::actionList();
        $permission = [];
        foreach ($permissionList as $value) {
            if ($value == 'dashboard') {
                array_push($permission, $action[0] . "_" . $value);
            } else {
                for ($i = 0; $i < 4; $i++) {
                    array_push($permission, $action[$i] . "_" . $value);
                }
            }
        }
        return $permission;
    }
}
