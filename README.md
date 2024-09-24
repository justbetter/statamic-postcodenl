<a href="https://github.com/justbetter/statamic-postcodenl" title="JustBetter">
    <img src="./art/banner.png" alt="Banner">
</a>

# Statamic Postcode.nl

> This addon adds Postcode.nl field types to the Form Builder.

## Installation

``` bash
composer require justbetter/statamic-postcodenl
```

## Configuration

Add the following items to your .env, these settings consist of the Key and Secret provided by Postcode.nl.

``` dotenv
POSTCODENL_KEY=""
POSTCODENL_SECRET=""
```

## How to Use

### Form settings

When building a form it's now possible to make use of the Postcode.nl fields.
When selecting the Postcode.nl field you need to select the according field type, these consist of:

- Zipcode (Required)
- House number (Required)
- House number addition (Optional)
- Street (Required)
- City (Required)


Make sure to add all the required field types to your form as they are needed for this to work.

### Tags

To add this functionality to your form you have to use our Postcode.nl tag.
At the bottom of your form view you need to add the following tag:

#### Antlers
``` php
{{ postcodenl:initPostcodenl :formId="form_handle" }}
```
#### Blade
``` php
{!! Statamic::tag('postcodenl:initPostcodenl')->param('formId', $form->handle)->fetch() !!}
```

As the Postcode.nl field types are an extend of the normal text field type, you can use this type the same way as the text field type for your forms.
For example you could still look at the `input_type` field to determine the field type you need to load into your form.

Make sure you're using the correct variable when passing the formId, this variable should be the handle of your form. i.e 'contact'.
