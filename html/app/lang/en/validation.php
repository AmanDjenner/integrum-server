<?php

$t = array(
    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */

    'hex' => 'The field can contain only digits and a-f letters',
    "accepted" => "The :attribute must be accepted.",
    "active_url" => "The :attribute is not a valid URL.",
    "after" => "The :attribute must be a date after :date.",
    "alpha" => "The :attribute may only contain letters.",
    "alpha_dash" => "The :attribute may only contain letters, numbers, and dashes.",
    "alpha_num" => "The field can contain only letters and digits.",
    "array" => "The :attribute must be an array.",
    "before" => "The :attribute must be a date before :date.",
    "between.numeric" => "Incorrect value - must be between :min and :max.",
    "between.file" => "The :attribute must be between :min and :max kilobytes.",
    "between.string" => "Incorrect number of characters - must be between :min and :max.",
    "between.array" => "The :attribute must have between :min and :max items.",
    "confirmed" => "The :attribute confirmation does not match.",
    "date" => "The :attribute is not a valid date.",
    "date_format" => "The :attribute does not match the format :format.",
    "different" => "Fields must be different.",
    "digits" => "The :attribute must be :digits digits.",
    "digits_between" => "Incorrect value - must be between :min and :max digits.",
    "email" => "The :attribute must be a valid email address.",
    "exists" => "The selected :attribute is invalid.",
    "image" => "The :attribute must be an image.",
    "in" => "The selected :attribute is invalid.",
    "integer" => "The field can contain only digits",
    "ip" => "The :attribute must be a valid IP address.",
    "max.numeric" => "Incorrect value - may not be greater than :max.",
    "max.file" => "The :attribute may not be greater than :max kilobytes.",
    "max.string" => "Incorrect number of characters - may not be more than :max.",
    "max.array" => "The :attribute may not have more than :max items.",
    "mimes" => "The :attribute must be a file of type: :values.",
    "min.numeric" => "Incorrect value - must be at least :min.",
    "min.file" => "The :attribute must be at least :min kilobytes.",
    "min.string" => "Incorrect number of characters - must be at least :min.",
    "min.array" => "The :attribute must have at least :min items.",
    "not_in" => "The selected :attribute is invalid.",
    "numeric" => "The field can contain only digits.",
    "regex" => "Incorrect format.",
    "required" => "The field is required",
    "required_if" => "The :attribute field is required when :other is :value.",
    "required_with" => "Both fields must be filled.",
    "required_with_all" => "The :attribute field is required when :values is present.",
    "required_without" => "The :attribute field is required when :values is not present.",
    "required_without_all" => "The :attribute field is required when none of :values are present.",
    "same" => "The :attribute and :other must match.",
    "size.numeric" => "Incorrect number of characters - must be :size.",
    "size.file" => "The :attribute must be :size kilobytes.",
    "size.string" => "Incorrect number of characters - must be :size.",
    "size.array" => "The :attribute must contain :size items.",
    "unique" => "The :attribute has already been taken.",
    "url" => "The :attribute format is invalid.",
    "exists_name_id" => "The user name already exists in the database",
    "exists_name" => "The user name already exists in the database",
    "exists_code" => "This code already exists",
    "exists_ipand_port" => "Module with this address and port has been already registered",
    "password_strong" => "Password must contains at least :min characters (one small letter, one big letter, one digit and one special character)",
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => array(
        'password' => array(
            'regex' => 'Password must contains at least one small letter, one big letter, one digit and one special character',
        ),
    ),
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => array(),
);

return $t;
