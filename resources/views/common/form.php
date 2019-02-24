<?php

use Illuminate\Support\Facades\Input;

$posted_data = $object->getAttributes();
foreach ($field_details as $field_name => $fields_types) {
//    echo $fields_types.'<br/>';
    $label_name = ucfirst(str_replace('_', ' ', $field_name));
    $required = '';
    if (!empty($required_fields) && in_array($field_name, $required_fields)) {
        $required = '<span class="text-danger">*</span>';
    }
    switch ($fields_types) {

        case 'text':
            echo '<div class="form-group">';
            echo '<label for="input_' . $field_name . '">' . $label_name . '</label> ' . $required;
            if ($field_name == 'phone_number') {
                echo '<input type="text" name="FormData[' . $field_name . ']" value="' . (!empty($posted_data[$field_name]) ? $posted_data[$field_name] : '') . '" placeholder="' . $label_name . '" id="input_' . $field_name . '" class="form-control" data-inputmask=\'"mask": "(999) 999-9999"\' data-mask>';
            } else {
                echo '<input type="text" name="FormData[' . $field_name . ']" value="' . (!empty($posted_data[$field_name]) ? $posted_data[$field_name] : '') . '" placeholder="' . $label_name . '" id="input_' . $field_name . '" class="form-control">';
            }
            echo '</div>';
            break;
        case 'textarea':
            echo '<div class="form-group">';
            echo '<label for="input_' . $field_name . '">' . $label_name . '</label> '. $required;
            echo '<textarea name="FormData[' . $field_name . ']" id="input_' . $field_name . '" placeholder="Enter ' . $label_name . '" rows="3" class="form-control">' . (!empty($posted_data[$field_name]) ? $posted_data[$field_name] : '') . '</textarea>';
            echo '</div>';
            break;
        case 'file':
            echo '<div class="form-group">
                      <label for="input_' . $field_name . '">' . $label_name . '</label> '. $required.'
                      <input type="file" id="input_' . $field_name . '" name="' . $field_name . '">
                      <p class="help-block">Please upload only pdf file.</p>
                    </div>';
            break;
        case 'radio':
            echo '<div class="form-group">';
            echo '<label>' . $label_name . '</label> '. $required;
            if ($table_name == 'referral_resources') {
                if ($field_name == 'accepting_patients')
                    $radio_values = array('1' => 'Yes', '0' => 'No');
                else if ($field_name == 'gender')
                    $radio_values = array('male' => 'Male', 'female' => 'Female');
            }

            $i = 1;
            foreach ($radio_values as $table_values => $labels) {
                $checked = '';
                if (isset($posted_data[$field_name])) {
                    if ($posted_data[$field_name] == $table_values) {
                        $checked = 'checked="checked"';
                    }
                } else {
                    if ($i == 1) {
                        $checked = 'checked="checked"';
                        $i++;
                    }
                }
                echo '<div class="radio"><label>';
                echo '<input type="radio" ' . $checked . ' name="FormData[' . $field_name . ']" value="' . $table_values . '" id="input_' . $field_name . '_' . $table_values . '">' . $labels;
                echo '</label></div>';
            }
            echo '</div>';
            break;
    }
}
?>
