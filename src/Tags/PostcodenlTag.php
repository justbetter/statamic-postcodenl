<?php

namespace JustBetter\StatamicPostcodenl\Tags;

use Statamic\Statamic;
use Statamic\Tags\Tags;

class PostcodenlTag extends Tags
{
    protected static $handle = 'postcodenl';

    public function initPostcodenl(): string
    {
        $formId = $this->params->get('formId');
        $form = Statamic::tag('form:' . $formId)->fetch();

        if (!$form) {
            return '';
        }

        $fields = $this->getPostcodenlFields($form);

        return view('justbetter-postcodenl::tags.postcodenl', ['postcodenlFields' => $fields]);
    }

    public function getPostcodenlFields(array $form): array
    {
        $postcodeserviceFields = [];

        if (!isset($form['fields']) || !$form['fields']) {
            return [];
        }

        foreach ($form['fields'] as $field) {
            if (!isset($field['input_type']) || !isset($field['handle']) || ($field['type'] ?? '') !== 'postcodenl' || !isset($field['postcodenl_type'])) {
                continue;
            }

            $postcodeserviceFields[$field['postcodenl_type']] = $field['handle'];
        }

        return $postcodeserviceFields;
    }
}
