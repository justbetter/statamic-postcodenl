<?php

namespace JustBetter\StatamicPostcodenl\Fieldtypes;


use Statamic\Fieldtypes\Text;

class Postcodenl extends Text
{
    protected $postcodenlFieldTypes = [
        'postcodenl_zipcode' => 'Postcode.nl Zipcode',
        'postcodenl_house_number' => 'Postcode.nl House number',
        'postcodenl_house_number_addition' => 'Postcode.nl House number addition',
        'postcodenl_street' => 'Postcode.nl Street',
        'postcodenl_city' => 'Postcode.nl City'
    ];

    protected $postcodenlDefaultFieldType = 'postcodenl_zipcode';

    protected function configFieldItems(): array
    {
        $config = parent::configFieldItems();

        $config['postcodenl_type'] = [
            'display' => __('Field type'),
            'instructions' => __('Select the Postcode.nl field type'),
            'type' => 'select',
            'default' => $this->postcodenlDefaultFieldType,
            'width' => 50,
            'options' => $this->postcodenlFieldTypes
        ];

        return $config;
    }
}
