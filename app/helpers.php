<?php

function splash_background()
{
    $images = [
        'crowd',
        'bandana',
        'mic',
        'candles',
    ];

    $img = $images[array_rand($images)];

    return asset(sprintf('img/%s.png', $img));
}

function gravatar_tag($email, $options = array())
{
  $hashed_email = md5($email);
  $args = http_build_query($options);

  return sprintf('<img src="//www.gravatar.com/avatar/%s?%s" alt="%s" />', $hashed_email, $args, $email);
}

function timestring($time)
{
  return date('M d, Y', strtotime($time));
}

function states()
{
  return array(
    ''  => 'State',
    'AL'=>'Alabama',
    'AK'=>'Alaska',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District of Columbia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PA'=>'Pennsylvania',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming',
  );
}

function timezones()
{
    $a = $b = array_map("strtoupper", array_keys(DateTimeZone::listAbbreviations()));
    return array_combine($a, $b);
}

function person_or_people($value)
{
    return $value == 1 ? 'person' : 'people';
}

function maps_url(array $args)
{
    return "//maps.google.com/?q=" . urlencode(implode('+', $args));
}

function city_state($city, $state)
{
    if ($city && $state) return "$city, $state";
    return rtrim("$city $state");
}

function error_message($message)
{
    return <<<EOF
<span class="glyphicon glyphicon-remove form-control-feedback"></span>
<div class="input-error"><small>$message</small></div>
EOF;
}
