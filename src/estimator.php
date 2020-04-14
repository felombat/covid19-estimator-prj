<?php

function covid19ImpactEstimator($data)
{
  // Parse Data
  /* Input 
  *  {
        region: {
        name: "Africa",
        avgAge: 19.7,
        avgDailyIncomeInUSD: 5,
        avgDailyIncomePopulation: 0.71
        },
        periodType: "days",
        timeToElapse: 58,
        reportedCases: 674,
        population: 66622705,
        totalHospitalBeds: 1380614
      } 
  */
  // Test Input 
  // $data = '{   
  //   "region":{
  //     "name":"Africa",
  //     "avgAge":19.7,
  //     "avgDailyIncomeInUSD":5,
  //     "avgDailyIncomePopulation":0.71
  //     },
  //       "periodType":"days",
  //       "timeToElapse":58,
  //       "reportedCases":674,
  //       "population":66622705,
  //       "totalHospitalBeds":1380614
  //   }'; 

 
  
  $_data = (object)$data;

  $result = array(); 
  $result['data']       = $data;
  $estimate['impact'] = [
                            'currentlyIntfected' => 0,
                            'infectionByRequestedtime' => 0,
                            'serveCasesByRequestedtime' => 0,
                            'hospitalBedsByRequestedtime' => 0,
                            'casesForICUByRequestedtime' => 0,
                            'casesForVentilatorsByRequestedtime' => 0,
                            'currentlyIntfected' => 0,
                            'dollarsInflight' => 0,
                          ];

  $estimate['severeImpact'] = [
                            'currentlyIntfected' => 0,
                            'infectionByRequestedtime' => 0,
                            'serveCasesByRequestedtime' => 0,
                            'hospitalBedsByRequestedtime' => 0,
                            'casesForICUByRequestedtime' => 0,
                            'casesForVentilatorsByRequestedtime' => 0,
                            'currentlyIntfected' => 0,
                            'dollarsInflight' => 0,
                          ];
  

  // json_validator($data);
  // //if (!is_object(json_decode($data))) {
  // if(!json_validator($data) ){
  //   $result->data = '{"error" :"Bad JSON Format"}';
  //   return json_encode($result); 
  //   exit(1);
  // }

   
  // Step 1 currentlyIntfected
  $estimate['impact']['currentlyIntfected']       = $data['reportedCases'] * 10; 
  $estimate['severeImpact']['currentlyIntfected'] = $data['reportedCases'] * 50; 


  // Step 1 infectionsByRequestedTime
   
  if($result['data']['periodType'] =="months"){
    $days = $result['data']['timeToElapse'] * 30 ;//$_data->timeToElapse * 30;
    $factor = floor($days / 3);
    $estimate['impact']['infectionsByRequestedTime'] = $estimate['impact']['currentlyIntfected'] ** $factor;
    $estimate['severeImpact']['infectionsByRequestedTime'] =  $estimate['severeImpact']['currentlyIntfected']  ** $factor;
    
    $estimate['impact']['severeCasesByRequestedTime']       = $estimate['impact']['infectionsByRequestedTime'] * 0.15;
    $estimate['severeImpact']['severeCasesByRequestedTime'] = $estimate['severeImpact']['infectionsByRequestedTime'] * 0.15;

  }elseif($result['data']['periodType'] =="weeks"){
    $days = $_data->timeToElapse * 7;
    $factor = floor($days / 3);
    $estimate['impact']['infectionsByRequestedTime'] = $estimate['impact']['currentlyIntfected'] ** $factor;
    $estimate['severeImpact']['infectionsByRequestedTime'] =  $estimate['severeImpact']['currentlyIntfected']  ** $factor;
    
    $estimate['impact']['severeCasesByRequestedTime']       = $estimate['impact']['infectionsByRequestedTime'] * 0.15;
    $estimate['severeImpact']['severeCasesByRequestedTime'] = $estimate['severeImpact']['infectionsByRequestedTime'] * 0.15;
     
  }else{
    $days = $_data->timeToElapse ;
    $factor = floor($days / 3);
    $estimate['impact']['infectionsByRequestedTime'] = $estimate['impact']['currentlyIntfected'] ** $factor;
    $estimate['severeImpact']['infectionsByRequestedTime'] =  $estimate['severeImpact']['currentlyIntfected']  ** $factor;
    
    $estimate['impact']['severeCasesByRequestedTime']       = $estimate['impact']['infectionsByRequestedTime'] * 0.15;
    $estimate['severeImpact']['severeCasesByRequestedTime'] = $estimate['severeImpact']['infectionsByRequestedTime'] * 0.15;
 
     
  }


  $result['estimate']['impact'] = $estimate['impact']; 
  $result['estimate']['severeImpact'] = $estimate['severeImpact']; 

  return  $result;
}
