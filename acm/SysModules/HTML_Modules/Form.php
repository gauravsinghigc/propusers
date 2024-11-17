<?php
//no data found View
function NoData($title, $desc = null)
{ ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-4">
                <div class="shadow-sm p-1">
                        <div class="p-1">
                                <h4 class="bold mt-3"><?php echo $title; ?></h4>
                                <p>
                                        <?php echo $desc; ?>
                                </p>
                        </div>
                </div>
        </div>
<?php }

//upload image with preview
function UploadImageInput($name, $id, $filetypes, $required = true, $class, $value = null)
{
        if ($required == true) {
                $req = "required=''";
        } else {
                $req = "";
        } ?>
        <div class="form-group <?php echo $class; ?>">
                <label>Upload Image</label>
                <input type="FILE" name="<?php echo $name; ?>" value="<?php echo $value; ?>" id="<?php echo $id; ?>" <?php echo $req; ?> accept="<?php echo $filetypes; ?>" class="form-control-2" />
        </div>
        <div class="col-md-12">
                <div class="flex-c mb-2-pr">
                        <img src="" id="<?php echo $id; ?>_img" class="imgrpreview">
                </div>
        </div>
        <script>
                <?php echo $id; ?>.onchange = evt => {
                        const [file] = <?php echo $id; ?>.files
                        if (file) {
                                <?php echo $id; ?>_img.src = URL.createObjectURL(file);
                        }
                }
        </script>
        <?php }

function InputOptions($data, $default = null)
{
        $RegOptions = $data;
        $Count = 0;
        $Returns = "";
        foreach ($RegOptions as $key => $options) {
                if ($options == $default) {
                        $selected = "selected=''";
                } else {
                        $selected = "";
                }

                $Returns .= "<option value='$options' $selected>$options</option>";
        }

        return $Returns;
}

function InputOptionsWithKey($data, $default = null)
{
        $RegOptions = $data;
        $Count = 0;
        $results = "";
        foreach ($RegOptions as $key => $options) {
                if ($key == $default) {
                        $selected = "selected";
                } else {
                        $selected = "";
                }

                $results .=   '<option value="' . $key . '" ' . $selected . '>' . $options . '</option>';
        }
        return $results;
}

//activation & deactivation options
function SelectStatus($data)
{
        if ($data == "1" or $data == "ACTIVE" or $data == "Active" or $data == 1) { ?>
                <option value="1" selected="">Active</option>
                <option value="2">Inactive</option>
        <?php } else { ?>
                <option value="1">Active</option>
                <option value="2" selected="">Inactive</option>
                <?php }
}



//function for list of all countries
function ALLCOUNTRIES($default = null, $suggest = false)
{
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        foreach ($countries as $country) {
                if ($country == $default) {
                        $selected = "selected";
                } else {
                        $selected = "";
                }
                if ($suggest == false) { ?>
                        <option value="<?php echo $country; ?>" <?php echo $selected; ?>><?php echo $country; ?></option>
                <?php
                } else {
                ?>
                        <option value="<?php echo $country; ?>" <?php echo $selected; ?>></option>
        <?php
                }
        }
}

//form start section
function Form_start($Formname, $action, $method, $encrptype = "", array $formattribute)
{
        global $Formname;
        ?>
        <form action="<?php echo CONTROLLER . "/" . $action; ?>" method="<?php echo $method; ?>" enctype="<?php echo $encrptype; ?>" <?php echo LOOP_TagsAttributes($formattribute); ?>>
        <?php
        FormPrimaryInputs(true);
}

//form end
function Form_end()
{
        ?>
        </form>
<?php
}

//select Fields
function SELECT_OPTION($name, $label, array $options, $req = "true", $class, $default)
{

        if ($req == "true") {
                $required = "required=''";
                $req_txt = '<span class="text-danger">*</span>';
        } else {
                $required = "";
                $req_txt = "";
        }
        echo "
   <div class='form-group $class'>
   <label>$label $req_txt</label>
  <select name='$name' id='$name' class='form-control' $required>
  ";

        foreach ($options as $key => $value) {
                if ($key == $default) {
                        echo "<option value='$value' selected=''>$value</option>";
                } else {
                        echo "<option value='$value'>$value</option>";
                }
        }

        echo "</select>
  </div>";
}


//textarea
function TEXTAREA($label, $name, $value, $req = "true", $rows, $class)
{
        if ($req == "true") {
                $required = "required=''";
                $req_txt = '<span class="text-danger">*</span>';
        } else {
                $required = "";
                $req_txt = "";
        } ?>
        <div class="form-group <?php echo $class; ?>">
                <label><?php echo $label; ?> <?php echo $req_txt; ?></label>
                <textarea style="height:100% !important;" name="<?php echo $name; ?>" value="<?php echo $value; ?>" rows="<?php echo $rows; ?>" class="form-control" <?php echo $required; ?>><?php echo $value; ?></textarea>
        </div>
<?php
}

//input with data list
function DATA_LIST($id, array $options)
{


        echo "<datalist id='$id'>";
        foreach ($options as $key => $value) {
                echo "<option value='$value'></option>";
        }
        echo "</datalist>";
}
