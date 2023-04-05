<?php

function binarySearch($arr, $x, $key) {

  $low = 0;
  $high = count($arr) - 1;


  while ($low <= $high) {
      $mid = floor(($low + $high) / 2);
      if ($arr[$mid][$key] <= $x && $x < $arr[$mid+1][$key]) {
          return $arr[$mid]['rate'];
      }

      if ($arr[$mid][$key] < $x) {
          $low = $mid + 1;
      }

      if ($arr[$mid][$key] > $x) {
          $high = $mid - 1;
      }

  }

  // If the search value is not found in the array, return null
  return null;
}


function calc_weight($w) {
  if ($w < 800) {
    $rate = 168;
  }
  elseif ($w == 1000) {
    $rate = 230;
  }
  elseif ($w > 2000) {
    $rate = 405;
  }
  else {
    $json_data = json_decode(file_get_contents('./JSON-data/weight.json'), true);
    $rate = binarySearch($json_data, $w, 'weight');
  }
  return $rate;
}


function calc_year($y) {
  if ($y < 2011) {
    $rate = 300;
  } elseif ($y > 2021) {
    $rate = 8500;
  } else {
    $json_data = json_decode(file_get_contents('./JSON-data/year.json'), true);
    $rate = binarySearch($json_data, $y, 'year');
  }
  return $rate;
}

function postcode_check($code) {
  $json_data = json_decode(file_get_contents('./JSON-data/postcode.json'), true);
  $outward = substr($code, 0, strlen($code)-3);
  $endcode = substr($code, strlen($outward), strlen($code));
  echo '<p>checking: '.$outward.'</p>';
  forEach($json_data as $outcode) {
    if($outcode['Outward Code'] == $outward) {
      return $outcode['rate'];
    }
  }
  return 0;
}

function value_calc($data){
  echo "<h1>Vehicle Information</h1>";
  echo "<p><strong>Make:</strong> " . $data['make'] . "</p>";
  echo "<p><strong>Year:</strong> " . $data['yearOfManufacture'] . "</p>";
  echo "<p><strong>Weight:</strong> " . $data['revenueWeight'] ?? null . "</p>";
  if (array_key_exists('revenueWeight', $data)) {
    $weight = $data['revenueWeight'];
  } 
  else {
    $weight = 1000;
  }
  
  $year = $data['yearOfManufacture'];
  $postcode = strtoupper($_POST['post_code']);
  $postcodeVal = postcode_check($postcode);
  if ($postcodeVal == 0) {
    echo 'Unfortunately we dont typically service your postcode, but feel free to contact us if you want to enquire further';
  }

  $weightVal = calc_weight($weight);
  $yearVal = calc_year($year);

  if ($weightVal == null || $yearVal == null) {
    echo '<p>Sorry, there was an issue processing your estimate, please contact us for a quote!</p>';
  }
  echo '<p>Postcode: '.$postcodeVal.' | Weight: '.$weightVal.' | Year: '.$yearVal.'</p>';
  $estimateVal = $postcodeVal + $weightVal + $yearVal;
  echo $estimateVal;
}


// main caller when submit button pressed.
if (isset($_POST['reg_num']) && isset($_POST['post_code'])) {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://driver-vehicle-licensing.api.gov.uk/vehicle-enquiry/v1/vehicles",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>"{\n\t\"registrationNumber\": \"" . $_POST['reg_num'] . "\"\n}",
	  CURLOPT_HTTPHEADER => array(
	    "x-api-key: xq1HDS4oNp4JY9GbIjTQu4lQ4w1mgZsT1QID63zI",
	    "Content-Type: application/json"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$api_data = json_decode($response, true);

	if (!isset($api_data['make'])) {
    echo "<p>No vehicle information found for registration number " . $_POST['reg_num'] . ".</p>";
	} else {
    value_calc($api_data);
	}
}

?>


