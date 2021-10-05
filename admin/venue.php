
<?php
ob_start();
session_start();
// redirect to login if username not set
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
$page = 'training';
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM venue";
$sqlforLang = "SELECT * FROM language;";
$resultforLang = mysqli_query($connect, $sqlforLang);
$result = mysqli_query($connect, $sql);

// PHP for delete row
if (isset($_POST['delete'])) {
  $id=$_POST['id'];
  echo $id;
  $sql_delete = "DELETE FROM venue WHERE venue_id='$id';";
  $result_delete = mysqli_query($connect, $sql_delete);
  if($result_delete) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Venue has been deleted";
    $_SESSION['msg_type'] = "danger";
    exit(); 
  } 
  else {
    echo 'Failed to delete' . mysqli_error($connect);
  }
}

// PHP for edit row
if (isset($_POST['update'])) {
  //escaping string for safety
  $id=$_POST['id'];
  $address=$_POST['venueSA'];
  $venueApt=$_POST['venueApt'];
  $country=$_POST['country'];
  $timezone=$_POST['venueTz'];
  $venueSta=$_POST['venueSta'];
  $venueCity=$_POST['venueCity'];
  $venueZip=$_POST['venueZip'];
  $venueCap=$_POST['venueCap'];
  $venueDes=$_POST['venueDes'];
  $venueCost=$_POST['venueCost'];
  $venuePhone=$_POST['venuePhone'];
  $venueEmail=$_POST['venueEmail'];
  $venue_id=$_POST['id'];
  $q7orExt1=$_POST['q7orExt'];
  $comment=$_POST['venueComm'];

 $sql_update = "UPDATE venue SET venue_streetaddress='$address', venue_aptsuite='$venueApt', venue_country='$country', venue_state='$venueSta', venue_zipcode='$venueZip', venue_timezone='$timezone', venue_capacity='$venueCap', venue_description='$venueDes', venue_cost='$venueCost', venue_phone='$venuePhone', venue_email='$venueEmail', venue_isqualiti7venue='$q7orExt1', venue_comment='$comment', venue_city='$venueCity' WHERE venue_id=$id";
  $result_update = mysqli_query($connect, $sql_update);
  if($result_update) {
    mysqli_close($connect);
    $_SESSION['status'] = "Venue updated successfully";
    $_SESSION['msg_type'] = "success";
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
  
  }    
  else {
    echo 'Failed to update' . mysqli_error($connect);
  }
  
}

if (isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    if($key != 'lang') {
      $copy[$key] = mysqli_real_escape_string ($connect, $value);
    }    
  }
  // preparing sql for venue has language
  $insertInVHL = 'INSERT INTO venue_has_language VALUES ';
  $valuesToAdd = array(); 
  //sql for venue
  $insertInVen = 'INSERT INTO venue(`venue_streetaddress`, `venue_aptsuite`, `venue_country`, `venue_state`, `venue_zipcode`, `venue_timezone`, `venue_capacity`, `venue_description`, `venue_cost`, `venue_phone`, `venue_email`, `venue_isqualiti7venue`, `venue_comment`, `venue_city`) VALUES ("' . $copy['venueSA'] . '","'. $copy['venueApt'] . '","' . $copy['country'] . '","' . $copy['venueSta'] . '","' . $copy['venueZip'] . '","' . $copy['venueTz'] . '","' . $copy['venueCap'] . '","' . $copy['venueDes'] . '","' . $copy['venueCost'] . '","' . $copy['venuePhone'] . '","' . $copy['venueEmail'] . '","' . $copy['q7orExt'] . '","' . $copy['venueComm'] . '","' . $copy['venueCity'] . '")';
  $result_add = mysqli_query($connect, $insertInVen);
  if($result_add) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    $_SESSION['status'] = "Venue added successfully";
    $_SESSION['msg_type'] = "success";
    exit();  
  }    
  else {
    echo 'Failed to update' . mysqli_error($connect);
  }
}

/*   if (mysqli_query($connect, $insertInVen)) {
    // id of last insertion in venue
    $id = mysqli_query($connect, "SELECT MAX(venue_id) FROM venue");
    $id = mysqli_fetch_array($id)[0];
    foreach($_POST["lang"] as $lang) {
      $valuesToAdd[] = "('".$lang."','".$id."')";
    }
    // preparing sql for venue has language
    $insertInVHL.= implode(",", $valuesToAdd);
    if(mysqli_query($connect, $insertInVHL)) {
      mysqli_close($connect);
      header('Location: ' . $_SERVER['PHP_SELF']);
    }  
  } else {
    echo 'Failed to add' . mysqli_error($connect);
  }*/ 
  ob_end_flush();
?>

<div class="col-sm-9 col-md-10 mt-3">
<?php
// Set session variables
if(isset($_SESSION['status']))
{
  ?>

  <div class="alert alert-<?php echo $_SESSION['msg_type'] ?>" role="alert" id="success-alert">
  <?php echo $_SESSION['status']; ?>
  </div>

  <?php
  unset($_SESSION['status']);
}
?>
  <h2 class="p-2" style="color:gray;border-bottom:1px solid black"><i class="fa fa-building"></i> Venues</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Address</th>
        <th scope="col">State</th>
        <th scope="col">Country</th>
        <th scope="col">Timezone</th>
        <th scope="col">Capacity</th>
        <th scope="col">Description</th>
        <th scope="col">Cost</th>
        <th scope="col">Qualiti7's venue?</th>
        <th scope="col" width="240px"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $index = 1;
      while ($row = mysqli_fetch_array($result)) {
        $languageJSON = json_decode(file_get_contents('languages.json'), TRUE);
        $sqlForVHL = 'SELECT * FROM venue_has_language WHERE venue_id = '.$row["venue_id"];
        $lan = [];
        $resultForVHL = mysqli_query($connect, $sqlForVHL);
        //concatenating languages a venue has and displaying
        while($row1 = mysqli_fetch_assoc($resultForVHL)) {
          $lan[] = $languageJSON[$row1['language_id']]['name'];
        }
        //is venue of qualiti7
        $b = '';
        if ($row['venue_isqualiti7venue'] == 1) {
          $b = "Yes";
        } else {
          $b = "No";
        }
        $location = array($row['venue_aptsuite'], $row['venue_streetaddress'], $row['venue_city']);
        echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . implode(', ', $location).  '</td>
              <td>' . $row['venue_state'] . '</td>
              <td>' . $row['venue_country'] . '</td>
              <td>' . $row['venue_timezone'] . '</td>
              <td>' . $row['venue_capacity'] . '</td>
              <td>' . $row['venue_description'] . '</td>
              <td>' . $row['venue_cost'] . '</td>
              <td>' . $b . '</td>
              <td>
              <button type="button" class="btn btn-primary btn-sm edit" title="Edit row" data-address="' . $row['venue_streetaddress'] . '" data-aptsuite="' . $row['venue_aptsuite'] . '" data-country="' . $row['venue_country'] . '" data-state="' . $row['venue_state'] . '" data-zipcode="' . $row['venue_zipcode'] . '" data-timezone="' . $row['venue_timezone'] . '" data-capacity="' . $row['venue_capacity'] . '" data-description="' . $row['venue_description'] .'" data-cost="' . $row['venue_cost'] . '" data-phone="' . $row['venue_phone'] . '" data-email="' . $row['venue_email'] .'" data-isqualiti7venue="' . $row['venue_isqualiti7venue'] .'" data-comment="' . $row['venue_comment'] .'" data-city="' . $row['venue_city'] . '" data-id="' . $row['venue_id'] . '"><i class="fa fa-edit"></i> Edit</button>
              <button type="button" class="btn btn-danger btn-sm delete" del-id="'  . $row['venue_id'] . '" title="Delete row"><i class="fa fa-trash"></i> Delete</button>
              <button type="button" class="btn btn-link expand-row btn-sm" data-bs-toggle="collapse" href="#venue'. $index . '" role="button" id="text_mode" title="Expand Row"><i class="fa fa-expand"></i></button>
              </td>
                
              </tr>
              <tr> 
                <td colspan="11" class="border-0 p-0">
                  <div class="collapse" id="venue'.$index.'">
                    <div class="card card-body">
                      <p><strong>Phone: </strong>'. $row['venue_phone'] .'</p>
                      <p><strong>Email: </strong>' . $row['venue_email'] .'</p>
                      <p><strong>Languages: </strong>'. implode(', ', $lan) .'</p>
                      <p><strong>Comments: </strong>' . $row['venue_comment'] .'</p>
                    </div>
                  </div>
                </td>
              </tr>';
              
          
         $index++;
      }
      ?>
    </tbody>
    
  </table>
  <button id="add-row" type="button" style="float:left;" class="btn btn-primary fs-5 py-1 btn-sm"><i class="fa fa-plus"></i> Add Venue</button>
</div>

</div>
<div>
  
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="addVenue" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addVenueheader">Add Venue</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="mainForm" action="" method="POST">
          <input type="hidden" name="id" id="venue_id" value="">
          <div class="mb-3">
            <label class="form-label">Venue Street Address</label>
            <input type="text" class="form-control" id="venueSA" name="venueSA" placeholder="Street Address"/>
          </div>
          <div class="mb-3">
            <label class="form-label">Apartment/Suite Number</label>
            <input type="text" class="form-control" id="venueApt" name="venueApt" placeholder="Apartment/Suite Number" />
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Country</label>
            <select id="country" class="form-select" name="country">
              <option value="" selected disabled>Choose a country</option>
              <optgroup>
              <option value="Canada">Canada</option>
              <option value="United States">United States</option>
              <option value="France">France</option>
            </optgroup>
            <optgroup label="---------------------">
              <option value="India">India</option>
              <option value="Italy">Italy</option>
              <option value="Netherlands">Netherlands</option>
              <option value="Belgium">Belgium</option>
              <option value="Finland">Finland</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="Cameroon">Cameroon</option>
              <option value="China">China</option>
              <option value="Indonesia">Indonesia</option>
              <option value="Japan">Japan</option>
              <option value="Afghanistan">Afghanistan</option>
              <option value="Albania">Albania</option>
              <option value="Algeria">Algeria</option>
              <option value="Andorra">Andorra</option>
              <option value="Antigua and Barbuda">Antigua and Barbuda</option>
              <option value="Argentina">Argentina</option>
              <option value="Armenia">Armenia</option>
              <option value="Australia">Australia</option>
              <option value="Austria">Austria</option>
              <option value="Azerbaijan">Azerbaijan</option>
              <option value="Bahamas">Bahamas</option>
              <option value="Bahrain">Bahrain</option>
              <option value="Bangladesh">Bangladesh</option>
              <option value="Barbados">Barbados</option>
              <option value="Belarus">Belarus</option>
              <option value="Belize">Belize</option>
              <option value="Benin">Benin</option>
              <option value="Bhutan">Bhutan</option>
              <option value="Bolivia">Bolivia</option>
              <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
              <option value="Botswana">Botswana</option>
              <option value="Brazil">Brazil</option>
              <option value="Brunei">Brunei</option>
              <option value="Bulgaria">Bulgaria</option>
              <option value="Burkina Faso">Burkina Faso</option>
              <option value="Burundi">Burundi</option>
              <option value="Cambodia">Cambodia</option>
              <option value="Cape Verde">Cape Verde</option>
              <option value="Central African Republic">Central African Republic</option>
              <option value="Chad">Chad</option>
              <option value="Chile">Chile</option>
              <option value="Colombia">Colombia</option>
              <option value="Comoros">Comoros</option>
              <option value="Congo">Congo</option>
              <option value="Costa Rica">Costa Rica</option>
              <option value="Cote d'Ivoire">Cote d'Ivoire</option>
              <option value="Croatia">Croatia</option>
              <option value="Cuba">Cuba</option>
              <option value="Cyprus">Cyprus</option>
              <option value="Czech Republic">Czech Republic</option>
              <option value="Denmark">Denmark</option>
              <option value="Djibouti">Djibouti</option>
              <option value="Dominica">Dominica</option>
              <option value="Dominican Republic">Dominican Republic</option>
              <option value="East Timor">East Timor</option>
              <option value="Ecuador">Ecuador</option>
              <option value="Egypt">Egypt</option>
              <option value="El Salvador">El Salvador</option>
              <option value="Equatorial Guinea">Equatorial Guinea</option>
              <option value="Eritrea">Eritrea</option>
              <option value="Estonia">Estonia</option>
              <option value="Ethiopia">Ethiopia</option>
              <option value="Fiji">Fiji</option>
              <option value="Gabon">Gabon</option>
              <option value="Gambia">Gambia</option>
              <option value="Georgia">Georgia</option>
              <option value="Germany">Germany</option>
              <option value="Ghana">Ghana</option>
              <option value="Greece">Greece</option>
              <option value="Grenada">Grenada</option>
              <option value="Guatemala">Guatemala</option>
              <option value="Guinea">Guinea</option>
              <option value="Guinea-Bissau">Guinea-Bissau</option>
              <option value="Guyana">Guyana</option>
              <option value="Haiti">Haiti</option>
              <option value="Honduras">Honduras</option>
              <option value="Hong Kong">Hong Kong</option>
              <option value="Hungary">Hungary</option>
              <option value="Iceland">Iceland</option>
              <option value="Iran">Iran</option>
              <option value="Iraq">Iraq</option>
              <option value="Ireland">Ireland</option>
              <option value="Israel">Israel</option>
              <option value="Jamaica">Jamaica</option>
              <option value="Jordan">Jordan</option>
              <option value="Kazakhstan">Kazakhstan</option>
              <option value="Kenya">Kenya</option>
              <option value="Kiribati">Kiribati</option>
              <option value="North Korea">North Korea</option>
              <option value="South Korea">South Korea</option>
              <option value="Kuwait">Kuwait</option>
              <option value="Kyrgyzstan">Kyrgyzstan</option>
              <option value="Laos">Laos</option>
              <option value="Latvia">Latvia</option>
              <option value="Lebanon">Lebanon</option>
              <option value="Lesotho">Lesotho</option>
              <option value="Liberia">Liberia</option>
              <option value="Libya">Libya</option>
              <option value="Liechtenstein">Liechtenstein</option>
              <option value="Lithuania">Lithuania</option>
              <option value="Luxembourg">Luxembourg</option>
              <option value="Macedonia">Macedonia</option>
              <option value="Madagascar">Madagascar</option>
              <option value="Malawi">Malawi</option>
              <option value="Malaysia">Malaysia</option>
              <option value="Maldives">Maldives</option>
              <option value="Mali">Mali</option>
              <option value="Malta">Malta</option>
              <option value="Marshall Islands">Marshall Islands</option>
              <option value="Mauritania">Mauritania</option>
              <option value="Mauritius">Mauritius</option>
              <option value="Mexico">Mexico</option>
              <option value="Micronesia">Micronesia</option>
              <option value="Moldova">Moldova</option>
              <option value="Monaco">Monaco</option>
              <option value="Mongolia">Mongolia</option>
              <option value="Montenegro">Montenegro</option>
              <option value="Morocco">Morocco</option>
              <option value="Mozambique">Mozambique</option>
              <option value="Myanmar">Myanmar</option>
              <option value="Namibia">Namibia</option>
              <option value="Nauru">Nauru</option>
              <option value="Nepal">Nepal</option>
              <option value="New Zealand">New Zealand</option>
              <option value="Nicaragua">Nicaragua</option>
              <option value="Niger">Niger</option>
              <option value="Nigeria">Nigeria</option>
              <option value="Norway">Norway</option>
              <option value="Oman">Oman</option>
              <option value="Pakistan">Pakistan</option>
              <option value="Palau">Palau</option>
              <option value="Panama">Panama</option>
              <option value="Papua New Guinea">Papua New Guinea</option>
              <option value="Paraguay">Paraguay</option>
              <option value="Peru">Peru</option>
              <option value="Philippines">Philippines</option>
              <option value="Poland">Poland</option>
              <option value="Portugal">Portugal</option>
              <option value="Puerto Rico">Puerto Rico</option>
              <option value="Qatar">Qatar</option>
              <option value="Romania">Romania</option>
              <option value="Russia">Russia</option>
              <option value="Rwanda">Rwanda</option>
              <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
              <option value="Saint Lucia">Saint Lucia</option>
              <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
              <option value="Samoa">Samoa</option>
              <option value="San Marino">San Marino</option>
              <option value="Sao Tome and Principe">Sao Tome and Principe</option>
              <option value="Saudi Arabia">Saudi Arabia</option>
              <option value="Senegal">Senegal</option>
              <option value="Serbia and Montenegro">Serbia and Montenegro</option>
              <option value="Seychelles">Seychelles</option>
              <option value="Sierra Leone">Sierra Leone</option>
              <option value="Singapore">Singapore</option>
              <option value="Slovakia">Slovakia</option>
              <option value="Slovenia">Slovenia</option>
              <option value="Solomon Islands">Solomon Islands</option>
              <option value="Somalia">Somalia</option>
              <option value="South Africa">South Africa</option>
              <option value="Spain">Spain</option>
              <option value="Sri Lanka">Sri Lanka</option>
              <option value="Sudan">Sudan</option>
              <option value="Suriname">Suriname</option>
              <option value="Swaziland">Swaziland</option>
              <option value="Sweden">Sweden</option>
              <option value="Switzerland">Switzerland</option>
              <option value="Syria">Syria</option>
              <option value="Taiwan">Taiwan</option>
              <option value="Tajikistan">Tajikistan</option>
              <option value="Tanzania">Tanzania</option>
              <option value="Thailand">Thailand</option>
              <option value="Togo">Togo</option>
              <option value="Tonga">Tonga</option>
              <option value="Trinidad and Tobago">Trinidad and Tobago</option>
              <option value="Tunisia">Tunisia</option>
              <option value="Turkey">Turkey</option>
              <option value="Turkmenistan">Turkmenistan</option>
              <option value="Tuvalu">Tuvalu</option>
              <option value="Uganda">Uganda</option>
              <option value="Ukraine">Ukraine</option>
              <option value="United Arab Emirates">United Arab Emirates</option>
              <option value="Uruguay">Uruguay</option>
              <option value="Uzbekistan">Uzbekistan</option>
              <option value="Vanuatu">Vanuatu</option>
              <option value="Vatican City">Vatican City</option>
              <option value="Venezuela">Venezuela</option>
              <option value="Vietnam">Vietnam</option>
              <option value="Yemen">Yemen</option>
              <option value="Zambia">Zambia</option>
              <option value="Zimbabwe">Zimbabwe</option>
    </optgroup>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Venue State</label>
            <input type="text" class="form-control" id="venueSta" name="venueSta" placeholder="Venue State" />
          </div>
          <div class="mb-3">
            <label class="form-label">Venue City</label>
            <input type="text" class="form-control" id="venueCity" name="venueCity" placeholder="City" required/>
          </div>
          <div class="mb-3">
            <label class="form-label">Zipcode</label>
            <input type="text" class="form-control" id="venueZip" name="venueZip" placeholder="Zip" />
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Timezone</label>
            <select id="timezone" class="form-select" name="venueTz" required>

            <option value="" disabled selected>Choose a Timezone</option>
            <option value="EST">EST - Eastern Standard Time</option>
            <option value="CET">CET - Central European Time</option>
            <option value="ADT">ADT - Atlantic Daylight Time</option>
            <option value="CST">CST - Central Standard Time</option>
            <option value="MST">MST - Mountain Standard Time</option>
            <option value="PST">PST - Pacific Standard Time</option>
              <option value="A">A - Alpha Time Zone</option>
              <option value="ACDT">ACDT - Australian Central Daylight Time</option>
              <option value="ACST">ACST - Australian Central Standard Time</option>
              <option value="ACT">ACT - Acre Time</option>
              <option value="ACT">ACT - Australian Central Time</option>
              <option value="ACWST">ACWST - Australian Central Western Standard Time</option>
              <option value="ADT">ADT - Arabia Daylight Time</option>
              <option value="ADT">ADT - Arabian Daylight Time</option>
              <option value="AEDT">AEDT - Australian Eastern Daylight Time</option>
              <option value="AEST">AEST - Australian Eastern Standard Time</option>
              <option value="AET">AET - Australian Eastern Time</option>
              <option value="AFT">AFT - Afghanistan Time</option>
              <option value="AKDT">AKDT - Alaska Daylight Time</option>
              <option value="AKST">AKST - Alaska Standard Time</option>
              <option value="ALMT">ALMT - Alma-Ata Time</option>
              <option value="AMST">AMST - Amazon Summer Time</option>
              <option value="AMST">AMST - Armenia Summer Time</option>
              <option value="AMT">AMT - Amazon Time</option>
              <option value="AMT">AMT - Armenia Time</option>
              <option value="ANAST">ANAST - Anadyr Summer Time</option>
              <option value="ANAT">ANAT - Anadyr Time</option>
              <option value="AQTT">AQTT - Aqtobe Time</option>
              <option value="ART">ART - Argentina Time</option>
              <option value="AST">AST - Arabia Standard Time</option>
              <option value="AST">AST - Arabian Standard Time</option>
              <option value="AST">AST - Atlantic Standard Time</option>
              <option value="AT">AT - Atlantic Time</option>
              <option value="AWDT">AWDT - Australian Western Daylight Time</option>
              <option value="AWST">AWST - Australian Western Standard Time</option>
              <option value="AZOST">AZOST - Azores Summer Time</option>
              <option value="AZOT">AZOT - Azores Time</option>
              <option value="AZST">AZST - Azerbaijan Summer Time</option>
              <option value="AZT">AZT - Azerbaijan Time</option>
              <option value="AoE">AoE - Anywhere on Earth</option>
              <option value="B">B - Bravo Time Zone</option>
              <option value="BNT">BNT - Brunei Darussalam Time</option>
              <option value="BOT">BOT - Bolivia Time</option>
              <option value="BRST">BRST - Brasília Summer Time</option>
              <option value="BRT">BRT - Brasília Time</option>
              <option value="BRT">BRT - Brasilia Time</option>
              <option value="BST">BST - Bangladesh Standard Time</option>
              <option value="BST">BST - Bougainville Standard Time</option>
              <option value="BST">BST - British Summer Time</option>
              <option value="BTT">BTT - Bhutan Time</option>
              <option value="C">C - Charlie Time Zone</option>
              <option value="CAST">CAST - Casey Time</option>
              <option value="CAT">CAT - Central Africa Time</option>
              <option value="CCT">CCT - Cocos Islands Time</option>
              <option value="CDT">CDT - Central Daylight Time</option>
              <option value="CDT">CDT - Cuba Daylight Time</option>
              <option value="CEST">CEST - Central European Summer Time</option>   
              <option value="CHADT">CHADT - Chatham Island Daylight Time</option>
              <option value="CHAST">CHAST - Chatham Island Standard Time</option>
              <option value="CHOST">CHOST - Choibalsan Summer Time</option>
              <option value="CHOT">CHOT - Choibalsan Time</option>
              <option value="CHUT">CHUT - Chuuk Time</option>
              <option value="CIDST">CIDST - Cayman Islands Daylight Saving Time</option>
              <option value="CIST">CIST - Cayman Islands Standard Time</option>
              <option value="CKT">CKT - Cook Island Time</option>
              <option value="CKT">CKT - Cook Islands Time</option>
              <option value="CLST">CLST - Chile Summer Time</option>
              <option value="CLT">CLT - Chile Standard Time</option>
              <option value="COT">COT - Colombia Time</option> 
              <option value="CST">CST - China Standard Time</option>
              <option value="CST">CST - Cuba Standard Time</option>
              <option value="CT">CT - Central Time</option>
              <option value="CVT">CVT - Cape Verde Time</option>
              <option value="CXT">CXT - Christmas Island Time</option>
              <option value="ChST">ChST - Chamorro Standard Time</option>
              <option value="D">D - Delta Time Zone</option>
              <option value="DAVT">DAVT - Davis Time</option>
              <option value="DDUT">DDUT - Dumont-d'Urville Time</option>
              <option value="E">E - Echo Time Zone</option>
              <option value="EASST">EASST - Easter Island Summer Time</option>
              <option value="EAST">EAST - Easter Island Standard Time</option>
              <option value="EAT">EAT - Eastern Africa Time</option>
              <option value="EAT">EAT - East Africa Time</option>
              <option value="ECT">ECT - Ecuador Time</option>
              <option value="EDT">EDT - Eastern Daylight Time</option>
              <option value="EEST">EEST - Eastern European Summer Time</option>
              <option value="EET">EET - Eastern European Time</option>
              <option value="EGST">EGST - Eastern Greenland Summer Time</option>
              <option value="EGT">EGT - East Greenland Time</option>
              <option value="ET">ET - Eastern Time</option>
              <option value="F">F - Foxtrot Time Zone</option>
              <option value="FET">FET - Further-Eastern European Time</option>
              <option value="FJST">FJST - Fiji Summer Time</option>
              <option value="FJT">FJT - Fiji Time</option>
              <option value="FKST">FKST - Falkland Islands Summer Time</option>
              <option value="FKT">FKT - Falkland Island Time</option>
              <option value="FKT">FKT - Falkland Islands Time</option>
              <option value="FNT">FNT - Fernando de Noronha Time</option>
              <option value="G">G - Golf Time Zone</option>
              <option value="GALT">GALT - Galapagos Time</option>
              <option value="GAMT">GAMT - Gambier Time</option>
              <option value="GET">GET - Georgia Standard Time</option>
              <option value="GFT">GFT - French Guiana Time</option>
              <option value="GILT">GILT - Gilbert Island Time</option>
              <option value="GMT">GMT - Greenwich Mean Time</option>
              <option value="GST">GST - Gulf Standard Time</option>
              <option value="GST">GST - South Georgia Time</option>
              <option value="GYT">GYT - Guyana Time</option>
              <option value="H">H - Hotel Time Zone</option>
              <option value="HDT">HDT - Hawaii-Aleutian Daylight Time</option>
              <option value="HKT">HKT - Hong Kong Time</option>
              <option value="HOVST">HOVST - Hovd Summer Time</option>
              <option value="HOVT">HOVT - Hovd Time</option>
              <option value="HST">HST - Hawaii Standard Time</option>
              <option value="HST">HST - Hawaii-Aleutian Standard Time</option>
              <option value="I">I - India Time Zone</option>
              <option value="ICT">ICT - Indochina Time</option>
              <option value="IDT">IDT - Israel Daylight Time</option>
              <option value="IOT">IOT - Indian Chagos Time</option>
              <option value="IRDT">IRDT - Iran Daylight Time</option>
              <option value="IRKST">IRKST - Irkutsk Summer Time</option>
              <option value="IRKT">IRKT - Irkutsk Time</option>
              <option value="IRST">IRST - Iran Standard Time</option>
              <option value="IST">IST - India Standard Time</option>
              <option value="IST">IST - Irish Standard Time</option>
              <option value="IST">IST - Israel Standard Time</option>
              <option value="JST">JST - Japan Standard Time</option>
              <option value="K">K - Kilo Time Zone</option>
              <option value="KGT">KGT - Kyrgyzstan Time</option>
              <option value="KOST">KOST - Kosrae Time</option>
              <option value="KRAST">KRAST - Krasnoyarsk Summer Time</option>
              <option value="KRAT">KRAT - Krasnoyarsk Time</option>
              <option value="KST">KST - Korea Standard Time</option>
              <option value="KUYT">KUYT - Kuybyshev Time</option>
              <option value="L">L - Lima Time Zone</option>
              <option value="LHDT">LHDT - Lord Howe Daylight Time</option>
              <option value="LHST">LHST - Lord Howe Standard Time</option>
              <option value="LINT">LINT - Line Islands Time</option>
              <option value="M">M - Mike Time Zone</option>
              <option value="MAGST">MAGST - Magadan Summer Time</option>
              <option value="MAGT">MAGT - Magadan Time</option>
              <option value="MART">MART - Marquesas Time</option>
              <option value="MAWT">MAWT - Mawson Time</option>
              <option value="MDT">MDT - Mountain Daylight Time</option>
              <option value="MHT">MHT - Marshall Islands Time</option>
              <option value="MMT">MMT - Myanmar Time</option>
              <option value="MSD">MSD - Moscow Daylight Time</option>
              <option value="MSK">MSK - Moscow Standard Time</option>   
              <option value="MT">MT - Mountain Time</option>
              <option value="MUT">MUT - Mauritius Time</option>
              <option value="MVT">MVT - Maldives Time</option>
              <option value="MYT">MYT - Malaysia Time</option>
              <option value="N">N - November Time Zone</option>
              <option value="NCT">NCT - New Caledonia Time</option>
              <option value="NDT">NDT - Newfoundland Daylight Time</option>
              <option value="NFDT">NFDT - Norfolk Daylight Time</option>
              <option value="NFT">NFT - Norfolk Time</option>
              <option value="NOVST">NOVST - Novosibirsk Summer Time</option>
              <option value="NOVT">NOVT - Novosibirsk Time</option>
              <option value="NPT">NPT - Nepal Time</option>
              <option value="NRT">NRT - Nauru Time</option>
              <option value="NST">NST - Newfoundland Standard Time</option>
              <option value="NUT">NUT - Niue Time</option>
              <option value="NZDT">NZDT - New Zealand Daylight Time</option>
              <option value="NZST">NZST - New Zealand Standard Time</option>
              <option value="O">O - Oscar Time Zone</option>
              <option value="OMSST">OMSST - Omsk Summer Time</option>
              <option value="OMST">OMST - Omsk Standard Time</option>
              <option value="ORAT">ORAT - Oral Time</option>
              <option value="P">P - Papa Time Zone</option>
              <option value="PDT">PDT - Pacific Daylight Time</option>
              <option value="PET">PET - Peru Time</option>
              <option value="PETST">PETST - Kamchatka Summer Time</option>
              <option value="PETT">PETT - Kamchatka Time</option>
              <option value="PGT">PGT - Papua New Guinea Time</option>
              <option value="PHOT">PHOT - Phoenix Island Time</option>
              <option value="PHT">PHT - Philippine Time</option>
              <option value="PKT">PKT - Pakistan Standard Time</option>
              <option value="PMDT">PMDT - Pierre & Miquelon Daylight Time</option>
              <option value="PMST">PMST - Pierre & Miquelon Standard Time</option>
              <option value="PONT">PONT - Pohnpei Standard Time</option>
              <option value="PST">PST - Pitcairn Standard Time</option>
              <option value="PT">PT - Pacific Time</option>
              <option value="PWT">PWT - Palau Time</option>
              <option value="PYST">PYST - Paraguay Summer Time</option>
              <option value="PYT">PYT - Paraguay Time</option>
              <option value="PYT">PYT - Pyongyang Time</option>
              <option value="Q">Q - Quebec Time Zone</option>
              <option value="QYZT">QYZT - Qyzylorda Time</option>
              <option value="R">R - Romeo Time Zone</option>
              <option value="RET">RET - Reunion Time</option>
              <option value="RET">RET - Réunion Time</option>
              <option value="ROTT">ROTT - Rothera Time</option>
              <option value="S">S - Sierra Time Zone</option>
              <option value="SAKT">SAKT - Sakhalin Time</option>
              <option value="SAMT">SAMT - Samara Time</option>
              <option value="SAST">SAST - South Africa Standard Time</option>
              <option value="SBT">SBT - Solomon Islands Time</option>
              <option value="SCT">SCT - Seychelles Time</option>
              <option value="SGT">SGT - Singapore Time</option>
              <option value="SRET">SRET - Srednekolymsk Time</option>
              <option value="SRT">SRT - Suriname Time</option>
              <option value="SST">SST - Samoa Standard Time</option>
              <option value="SYOT">SYOT - Syowa Time</option>
              <option value="T">T - Tango Time Zone</option>
              <option value="TAHT">TAHT - Tahiti Time</option>
              <option value="TFT">TFT - French Southern and Antarctic Time</option>
              <option value="TFT">TFT - French Southern & Antarctic Time</option>
              <option value="TJT">TJT - Tajikistan Time</option>
              <option value="TKT">TKT - Tokelau Time</option>
              <option value="TLT">TLT - East Timor Time</option>
              <option value="TMT">TMT - Turkmenistan Time</option>
              <option value="TOST">TOST - Tonga Summer Time</option>
              <option value="TOT">TOT - Tonga Time</option>
              <option value="TRT">TRT - Turkey Time</option>
              <option value="TVT">TVT - Tuvalu Time</option>
              <option value="U">U - Uniform Time Zone</option>
              <option value="ULAST">ULAST - Ulaanbaatar Summer Time</option>
              <option value="ULAT">ULAT - Ulaanbaatar Time</option>
              <option value="UTC">UTC - Coordinated Universal Time</option>
              <option value="UYST">UYST - Uruguay Summer Time</option>
              <option value="UYT">UYT - Uruguay Time</option>
              <option value="UZT">UZT - Uzbekistan Time</option>
              <option value="V">V - Victor Time Zone</option>
              <option value="VET">VET - Venezuelan Standard Time</option>
              <option value="VET">VET - Venezuela Standard Time</option>
              <option value="VLAST">VLAST - Vladivostok Summer Time</option>
              <option value="VLAT">VLAT - Vladivostok Time</option>
              <option value="VOST">VOST - Vostok Time</option>
              <option value="VUT">VUT - Vanuatu Time</option>
              <option value="W">W - Whiskey Time Zone</option>
              <option value="WAKT">WAKT - Wake Time</option>
              <option value="WARST">WARST - Western Argentine Summer Time</option>
              <option value="WAST">WAST - West Africa Summer Time</option>
              <option value="WAT">WAT - West Africa Time</option>
              <option value="WEST">WEST - Western European Summer Time</option>
              <option value="WET">WET - Western European Time</option>
              <option value="WFT">WFT - Wallis and Futuna Time</option>
              <option value="WGST">WGST - Western Greenland Summer Time</option>
              <option value="WGT">WGT - West Greenland Time</option>
              <option value="WIB">WIB - Western Indonesian Time</option>
              <option value="WIT">WIT - Eastern Indonesian Time</option>
              <option value="WITA">WITA - Central Indonesian Time</option>
              <option value="WITA">WITA - Central Indonesia Time</option>
              <option value="WST">WST - West Samoa Time</option>
              <option value="WST">WST - Western Sahara Summer Time</option>
              <option value="WT">WT - Western Sahara Standard Time</option>
              <option value="X">X - X-ray Time Zone</option>
              <option value="Y">Y - Yankee Time Zone</option>
              <option value="YAKST">YAKST - Yakutsk Summer Time</option>
              <option value="YAKT">YAKT - Yakutsk Time</option>
              <option value="YAPT">YAPT - Yap Time</option>
              <option value="YEKST">YEKST - Yekaterinburg Summer Time</option>
              <option value="YEKT">YEKT - Yekaterinburg Time</option>
              <option value="Z">Z - Zulu Time Zone</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Capacity</label>
            <input type="number" class="form-control" id="venueCap" name="venueCap" placeholder="Venue Capacity" />
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Description</label>
            <textarea name="venueDes" id="venueDes" placeholder="Description" class="form-control" rows="5" style="resize: none;"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Cost</label>
            <input type="text" class="form-control" id="venueCost" name="venueCost" placeholder="Venue Cost" />
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Language</label>
            <select name="lang[]" multiple class="selectpicker w-100">
            <?php 
                $languageJSON = json_decode(file_get_contents('languages.json'), TRUE);
                foreach($languageJSON as $key => $value) {
                  echo '<option value="'.$key.'">'.$value['name'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Phone</label>
            <input type="text" class="form-control" id="venuePhone" name="venuePhone" placeholder="Phone[+1234567890]" pattern="[\+]{0,1}[0-9]+"/>
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Email</label>
            <input type="email" class="form-control" id="venueEmail" name="venueEmail" placeholder="Venue Email" />
          </div>
          <div class="mb-3">
            <label class="form-label">Is it Qualiti7's venue?</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="q7orExt" id="q7orExt1" value="1" required>
              <label class="form-check-label" for="q7orExt1">
                Qualiti7's venue
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="q7orExt" id="q7orExt2" value="0" required>
              <label class="form-check-label" for="q7orExt2">
                External Venue
              </label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Venue Comments</label>
            <input type="text" class="form-control" id="venueComm" name="venueComm" placeholder="Venue Comment" />
          </div>

          <input id="submit" class="btn btn-gold text-light d-block ms-auto" name="submit" type="submit" value="Submit">

        </form>
      </div>
    </div>
  </div>
</div>

<!------ Modal for confirm delete -------> 

<!-- Modal HTML -->
<div id="confirm" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header flex-column">
					
				<h4 class="modal-title w-100">Are you sure?</h4>	
        <button type="button" class="close btn-close" id="close-modal" aria-label="Close" onclick="$('#confirm').modal('hide');"></button>
			</div>
      <form id="deleteForm" action="" method="POST">
      <input type="hidden" name="id" id="venue_del_id" value="">
			<div class="modal-body">
				<p>Do you really want to delete these records? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" onclick="$('#confirm').modal('hide');">Cancel</button>
				<input id="delete" name="delete" class="btn btn-danger ms-auto" type="submit" value="Delete">
			</div>
      </form>
	</div>
</div>     

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// function for EDIT ROW
$( ".edit" ).click(function() {
// clear all fields
  $('#mainForm')[0].reset();
// get data from edit button object
  var address = $(this).attr('data-address');
  var aptsuite = $(this).attr('data-aptsuite');
  var country = $(this).attr('data-country');
  var state = $(this).attr('data-state');
  var zipcode = $(this).attr('data-zipcode');
  var timezone = $(this).attr('data-timezone');
  var capacity = $(this).attr('data-capacity');
  var description = $(this).attr('data-description');
  var cost = $(this).attr('data-cost');
  var phone = $(this).attr('data-phone');
  var email = $(this).attr('data-email');
  var isqualiti7venue = $(this).attr('data-isqualiti7venue');
  var comment = $(this).attr('data-comment');
  var city = $(this).attr('data-city');
  var id = $(this).attr('data-id');
// set values on form
  $('#venueSA').val(address);
  $('#venueApt').val(aptsuite);
  $('#country').val(country);
  $('#timezone').val(timezone);
  $('#venueSta').val(state);
  $('#venueCity').val(city);
  $('#venueZip').val(zipcode);
  $('#venueCap').val(capacity);
  $('#venueDes').val(description);
  $('#venueCost').val(cost);
  $('#venuePhone').val(phone);
  $('#venueEmail').val(email);
  $('#venue_id').val(id);
  $('#venueComm').val(comment);
// set radio button value 
  if (isqualiti7venue=="1") {
    $("#q7orExt1").prop("checked", true);
  } 
  else {
    $("#q7orExt2").prop("checked", true);
  }
// set attributes of submit button 
  $('#submit').attr('name', 'update');
  $('#submit').val("Update Venue");
// change form header
  $("#addVenueheader").html("Edit Venue");
// open form
  $('#addVenue').modal('show');
});

// function for ADD ROW
$( "#add-row" ).click(function() {
// clear all fields
  $('#mainForm')[0].reset();
// set submit attributes
  $('#submit').attr('name', 'submit');
  $('#submit').val("Submit");
// change form header
  $("#addVenueheader").html("Add Venue");
// open form
  $('#addVenue').modal('show');
});

// function for DELETE ROW
$( ".delete" ).click(function() {
  var id = $(this).attr('del-id');
  $('#venue_del_id').val(id);
// open form to confirm delete
  $('#confirm').modal('show');
});

// function for success alert fadeout
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);

</script>



<?php
include('_adminincludes/footer.php')
?>

