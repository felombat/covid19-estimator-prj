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
  $result['impact']       = array();
  $result['severeImpact'] = array();

  // json_validator($data);
  // //if (!is_object(json_decode($data))) {
  // if(!json_validator($data) ){
  //   $result->data = '{"error" :"Bad JSON Format"}';
  //   return json_encode($result); 
  //   exit(1);
  // }

  $result['data'] = $data;
  $result['impact']['currentlyIntfected'] = $data['reportedCases'] * 10; 
  $result ['severeImpact']['currentlyIntfected'] = $data['reportedCases'] * 50; 

  if($result['data']['periodType'] =="months"){
    $days = $result['data']['timeToElapse'] * 30 ;//$_data->timeToElapse * 30;
    $factor = floor($days / 3);
    $result['impact']['infectionsByRequestedTime'] =  $result['impact']['currentlyIntfected'] ** $factor;
    $result['severeImpact']['infectionsByRequestedTime'] =  $result['severeImpact']['currentlyIntfected']  ** $factor; 
    $result['impact']['severeCasesByRequestedTime'] = $result['impact']['infectionsByRequestedTime'] * 0.15;
    $result['severeImpact']['severeCasesByRequestedTime'] = $result['severeImpact']['infectionsByRequestedTime'] * 0.15;
  }elseif($result['data']['periodType'] =="weeks"){
    $days = $_data->timeToElapse * 7;
    $factor = floor($days / 3);
    $result['impact']['infectionsByRequestedTime'] =  $result['impact']['currentlyIntfected'] ** $factor;
    $result['severeImpact']['infectionsByRequestedTime'] =  $result['severeImpact']['currentlyIntfected']  ** $factor; 
    $result['impact']['severeCasesByRequestedTime'] = $result['impact']['infectionsByRequestedTime'] * 0.15;
    $result['severeImpact']['severeCasesByRequestedTime'] = $result['severeImpact']['infectionsByRequestedTime'] * 0.15;

  }else{
    $days = $_data->timeToElapse ;
    $factor = floor($days / 3);
    $result['impact']['infectionsByRequestedTime'] =  $result['impact']['currentlyIntfected'] ** $factor;
    $result['severeImpact']['infectionsByRequestedTime'] =  $result['severeImpact']['currentlyIntfected']  ** $factor; 
    $result['impact']['severeCasesByRequestedTime'] = $result['impact']['infectionsByRequestedTime'] * 0.15;
    $result['severeImpact']['severeCasesByRequestedTime'] = $result['severeImpact']['infectionsByRequestedTime'] * 0.15;

  }



  return  $result;
}
