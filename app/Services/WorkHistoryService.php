<?php

namespace App\Services;

use App\Models\Industry;

class WorkHistoryService
{

    /**
     * recreate work history array
     *
     * @return array
     */
    public function formatWorkHistoryArr($workHistoryArr): array
    {
        $workHistory = array();

        $ctr = 0;
        foreach ($workHistoryArr as $key => $value) {

            $workHistory[$ctr]['id'] = $value['id'];            
            $workHistory[$ctr]['start_date'] = $value['start_date'];
            $workHistory[$ctr]['end_date'] = $value['end_date'];
            $workHistory[$ctr]['company_name'] = $value['company_name'];
            $workHistory[$ctr]['job_title'] = $value['job_title'];
            $workHistory[$ctr]['description'] = $value['description'];

            //compute diplay date
            $startDate = date_create($value['start_date']);
            $endDate = date_create($value['end_date']);
            
            $return_string = date_format($startDate,"F Y") .' - ';
            $return_string .=  null == $value['end_date'] ? 'Present' : date_format($endDate,"F Y");
            $return_string .= ' ';

            if(empty($value['end_date'])) {
                $endDate = date_create()->format('Y-m-d');
                $endDate = date_create($endDate);
            }

            $interval = date_diff($startDate, $endDate);
            $year_interval = $interval->y;
            $month_interval = $interval->m;

            $final_string = '';
            if( 0 != $year_interval ) {
                $final_string .= $year_interval . ' year/s';
            }

            if( 0 != $month_interval ) {
                $final_string .= ' ';
                $final_string .= $month_interval . ' month/s';
            }
            $final_string = empty($final_string) ? '' : '('.$final_string.')';
            
            $workHistory[$ctr]['display_date'] = $return_string.$final_string;


            //worktype array
            $workHistory[$ctr]['work_type'] = $value['work_type'];

            //format key_accountabilities
            $data = rtrim($value['key_accountabilities'],'"]');
            $data = ltrim($data,'["');
            $explode = explode('","', $data);
            $workHistory[$ctr]['key_accountabilities'] = $explode;

            if(isset($value['work_history_industry'])) {
                $workHistory[$ctr]['industries'] = array_column($value['work_history_industry'], 'industry_id');
            }

            $ctr++;

        }

        return $workHistory;
    }

    /**
     * compute experience days
     *
     * @return array
     */
    public function computeExperienceDays($start_date, $end_date)
    {
        $startDate = date_create($start_date);
        $endDate = date_create($end_date);

        if(empty($end_date)) {
            $endDate = date_create()->format('Y-m-d');
            $endDate = date_create($endDate);
        }

        if ($endDate < $startDate) {
            return 0;
        }

        $interval = date_diff($startDate, $endDate);
        $days_interval = $interval->d;

        return $days_interval;
    }

    /**
     * recreate work history array
     *
     * @return array
     */
    public function getDisplayDate($start_date, $end_date)
    {
        $startDate = date_create($start_date);
        $endDate = date_create($end_date);
        
        $return_string = date_format($startDate,"F Y") .' - ';
        $return_string .=  null == $end_date ? 'Present' : date_format($endDate,"F Y");
        $return_string .= ' ';

        if(empty($end_date)) {
            $endDate = date_create()->format('Y-m-d');
            $endDate = date_create($endDate);
        }

        $interval = date_diff($startDate, $endDate);
        $year_interval = $interval->y;
        $month_interval = $interval->m;

        $final_string = '';
        if( 0 != $year_interval ) {
            $final_string .= $year_interval . ' year/s';
        }

        if( 0 != $month_interval ) {
            $final_string .= ' ';
            $final_string .= $month_interval . ' month/s';
        }
        $final_string = empty($final_string) ? '' : '('.$final_string.')';
        
        $display_date = $return_string.$final_string;

        return $display_date;
    }

}
