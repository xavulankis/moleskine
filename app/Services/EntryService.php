<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Models



class EntryService
{    

    /**
     *  Get array with the name of the tags for this entry
     * 
     * @param Entry $entry
     * @param string $separator Value to separate between tags (- / *) 
     */
    public function getEntryTagsNames(Entry $entry): array
    {
        $tags = $entry->tags;        
        $result = [];

        foreach ($tags as $tag) {         
                $result[] = $tag->name;         
        }

        return $result;
    }

    public function getStatsTime(string $time): mixed
    {
        $data = Entry::where('user_id', '=', Auth::id())->get();

        if ($time == 'today') 
        {                                
            $expenses = $data->whereBetween('date', [now()->subDays(1), now()])->where('type', '=', 0)->sum('value');
            $income = $data->whereBetween('date', [now()->subDays(1), now()])->where('type', '=', 1)->sum('value');
        }

        if ($time == 'week') 
        {                                
            $expenses = $data->whereBetween('date', [now()->subDays(7), now()])->where('type', '=', 0)->sum('value');
            $income = $data->whereBetween('date', [now()->subDays(7), now()])->where('type', '=', 1)->sum('value');
        }

        if ($time == 'month') 
        {                                
            $expenses = $data->whereBetween('date', [now()->subDays(30), now()])->where('type', '=', 0)->sum('value');
            $income = $data->whereBetween('date', [now()->subDays(30), now()])->where('type', '=', 1)->sum('value');
        }
        
        return $income - $expenses;
    }
    
    /**
     * Get the tag names given an array with the tag ids
     */

    public function getTagNames(array $tags): array
    {
        $tagsNames = [];
        foreach ($tags as $key => $value) {
            $tagInfo = Tag::find($value);
            $tagsNames[] = $tagInfo->name;
        }
        return $tagsNames;
    }

    /**
     * Get user name
     */

    public function getUserName(int $userID): string
    {
        return User::where('id','=',$userID)->value('name');        
    }

    /**
     * Get Criteria for Export Excel filename
     * Given an associative array, sort and return a string
     */

    public function getCriteriaFilename(array $criteriaSelection): string
    {
        ksort($criteriaSelection);
        //$criterin = implode('_', $criterias);
        //dd($criterias);
        $resultado = '';
        foreach ($criteriaSelection as $key => $value) {
            $resultado .= $key . '_';
            $resultado .= $value . '_';
        }
        $resultado = str_replace(' ','-',$resultado);
        $resultado = str_replace(',','',$resultado); 
        
        return $resultado;
    }

    /**
     *  Search and extract values from an array based on a key
    */

    public function getArrayValues(array $data, string $keyName): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[] = $value[$keyName];
        }

        return $result;
    }

    

    public function getStatsArrayOrder(array $data, string $keyName): array
    {
        $result['total'] = 0;
        $list = [];

        $list = $this->getArrayValues($data,$keyName);
        natcasesort($list);
        
        $result['total'] = count(array_unique($list));
        $list = array_count_values($list);        

        // Combine key - values of the array to a single array with name and number of apperances
        $listCombined = [];

        foreach ($list as $key => $value) {
            $listCombined[] = $key . ' (' . $value . ')';
        }

        $result['list'] = $listCombined;

        return $result;

    }

    /**
     * Stats for the current entries found 
     * 
     */

    public function getTotalStats(array $data): array
    {
        $result = [];
        
        if($data == [])
        {
            return $result;
        }
       
        // Users
        $users = $this->getArrayValues($data,'user_id');
        $result['users'] = count(array_unique($users));        

        // Dates
        $dates = $this->getArrayValues($data,'date');
        $result['days'] = count(array_unique($dates));
        $result['dateFrom'] = min(array_unique($dates));
        $result['dateTo'] = max(array_unique($dates));      
       

        // Categories        
        $categoriesStats = $this->getStatsArrayOrder($data,'category_name');
        $result['numberCategories'] = $categoriesStats['total'];
        $result['categories'] = $categoriesStats['list'];

        return $result;
        
    }

}