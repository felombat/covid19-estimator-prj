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
  $result['currentlyInfected'] = array();

  // json_validator($data);
  // //if (!is_object(json_decode($data))) {
  // if(!json_validator($data) ){
  //   $result->data = '{"error" :"Bad JSON Format"}';
  //   return json_encode($result); 
  //   exit(1);
  // }

  $result['data'] = $data;
  $result['currentlyIntfected']['impact'] = $data['reportedCases'] * 10; 
  $result['currentlyIntfected']['severeImpact'] = $data['reportedCases'] * 50; 

  if($result['data']['periodType'] =="months"){
    $days = $result['data']['timeToElapse'] * 30 ;//$_data->timeToElapse * 30;
    $factor = floor($days / 3);
    $result['infectionsByRequestedTime']['impact'] =  $result['currentlyIntfected']['impact'] ** $factor;
    $result['infectionsByRequestedTime']['severeImpact'] =  $result['currentlyIntfected']['severeImpact']  ** $factor; 
    $result['severeCasesByRequestedTime']['impact'] = $result['infectionsByRequestedTime']['impact'] * 0.15;
    $result['severeCasesByRequestedTime']['severeImpact'] = $result['infectionsByRequestedTime']['severeImpact'] * 0.15;
  }elseif($result['data']['periodType'] =="weeks"){
    $days = $_data->timeToElapse * 7;
    $factor = floor($days / 3);
        $result['infectionsByRequestedTime']['impact'] =  $result['currentlyIntfected']['impact'] ** $factor;
    $result['infectionsByRequestedTime']['severeImpact'] =  $result['currentlyIntfected']['severeImpact']  ** $factor; 
    $result['severeCasesByRequestedTime']['impact'] = $result['infectionsByRequestedTime']['impact'] * 0.15;
    $result['severeCasesByRequestedTime']['severeImpact'] = $result['infectionsByRequestedTime']['severeImpact'] * 0.15;
  }else{
    $days = $_data->timeToElapse ;
    $factor = floor($days / 3);
        $result['infectionsByRequestedTime']['impact'] =  $result['currentlyIntfected']['impact'] ** $factor;
    $result['infectionsByRequestedTime']['severeImpact'] =  $result['currentlyIntfected']['severeImpact']  ** $factor; 
    $result['severeCasesByRequestedTime']['impact'] = $result['infectionsByRequestedTime']['impact'] * 0.15;
    $result['severeCasesByRequestedTime']['severeImpact'] = $result['infectionsByRequestedTime']['severeImpact'] * 0.15;
  }



  return  $result;
}
