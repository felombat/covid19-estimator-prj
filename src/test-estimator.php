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

 
  
  $_data = json_decode($data);

  $result = new stdClass(); 
  $result->data         = new stdClass();
  $result->impact       = new stdClass();
  $result->severeImpact = new stdClass();

  json_validator($data);
  //if (!is_object(json_decode($data))) {
  if(!json_validator($data) ){
    $result->data = '{"error" :"Bad JSON Format"}';
    return json_encode($result); 
    exit(1);
  }

  $result->data = $_data;
  $result->impact->currentlyIntfected = $_data->reportedCases * 10; 
  $result->severeImpact->currentlyIntfected = $_data->reportedCases * 50; 

  if($result->data->periodType =="months"){
    $days = $_data->timeToElapse * 30;
    $factor = floor($days / 3);
    $result->impact->infectionsByRequestedTime = $result->impact->currentlyIntfected * $factor;
    $result->severeImpact->infectionsByRequestedTime = $result->severeImpact->currentlyIntfected * $factor; 

  }elseif($result->data->periodType =="weeks"){
    $days = $_data->timeToElapse * 7;
    $factor = floor($days / 3);
    $result->impact->infectionsByRequestedTime = $result->impact->currentlyIntfected * $factor; 
    $result->severeImpact->infectionsByRequestedTime = $result->severeImpact->currentlyIntfected * $factor;

  }else{
    $days = $_data->timeToElapse ;
    $factor = floor($days / 3);
    $result->impact->infectionsByRequestedTime = $result->impact->currentlyIntfected * $factor; 
    $result->severeImpact->infectionsByRequestedTime = $result->severeImpact->currentlyIntfected * $factor;

  }



  return  json_encode($result);
}

function json_validator($data=NULL) {
  if (!empty($data)) {
                @json_decode($data);
                return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
}


$data = '{   "region":{
      "name":"Africa",
      "avgAge":19.7,
      "avgDailyIncomeInUSD":5,
      "avgDailyIncomePopulation":0.71
   
},
   "periodType":"days",
   "timeToElapse":58,
   "reportedCases":674,
   "population":66622705,
   "totalHospitalBeds":1380614
}'; 

  //$_data = json_encode($data);

$res = covid19ImpactEstimator(json_decode($data)); 

$page = <<<EOF
<pre> $res  </pre>
EOF;

//var_dump($res); 

echo $page; 