<?php

       namespace Framework\Core\Form;

       use http\Exception\InvalidArgumentException;
       use LogicException;

       class Generator
       {

              /**
               * @brief form configuration
               */
              protected $config;
              /**
               * @brief form content container
               */
              protected $form;
              /**
               * @brief
               */
              protected $output;
              private $protection_code;
              /**
               * @brief sent data holder
               */
              protected $input;
              /**
               * @brief errors
               */
              protected $error;
              /**
               * @brief error content
               */
              protected $error_box;
              /**
               * @brief protection field
               */
              protected $protection_field;
              /**
               * @brief validator object
               */
              protected $form_validator;
              /**
               * @brief fields array
               */
              protected $fields = [];
              /**
               * @brief fields array saved input data
               */
              protected $valid_input = false;
              /**     *
               * @brief have groups been defined
               */
              protected $has_groups = false;

              /**
               * @brief form constructor
               */
              public function __construct()
              {
                     //config options
                     $this->config['title']['type']             = 'str';
                     $this->config['name']['type']              = 'str';
                     $this->config['action']['type']            = 'str';
                     $this->config['action']['class']           = 'str';
                     $this->config['method']['type']            = 'enum';
                     $this->config['validator']['type']         = 'str';
                     $this->config['validatorClass']['type']    = 'str';
                     $this->config['labelAfter']['type']        = 'str';
                     $this->config['sanitize']['type']          = 'bool';
                     $this->config['submitMessage']['type']     = 'str';
                     $this->config['showDebug']['type']         = 'bool';
                     $this->config['linebreaks']['type']        = 'str';
                     $this->config['divs']['type']              = 'bool';
                     $this->config['html5']['type']             = 'bool';
                     $this->config['placeholders']['type']      = 'bool';
                     $this->config['showErrors']['type']        = 'bool';
                     $this->config['errorTitle']['type']        = 'str';
                     $this->config['errorLabel']['type']        = 'str';
                     $this->config['errorPosition']['type']     = 'enum';
                     $this->config['showAfterSuccess']['type']  = 'bool';
                     $this->config['cleanAfterSuccess']['type'] = 'bool';
                     $this->config['submitField']['type']       = 'str';
                     //config allowed values
                     $this->config['method']['allowed']        = ['get', 'post'];
                     $this->config['errorPosition']['allowed'] = ['before', 'after', 'in_before', 'in_after'];
                     //config defaults
                     $this->config['validatorClass']['value']    = Validator::class;
                     $this->config['method']['value']            = 'post';
                     $this->config['sanitize']['value']          = true;
                     $this->config['submitMessage']['value']     = 'Form successfully submitted!';
                     $this->config['errorPosition']['value']     = 'in_before';
                     $this->config['errorTitle']['value']        = '(!) Error:';
                     $this->config['errorLabel']['value']        = '<span>(!)</span>';
                     $this->config['linebreaks']['value']        = '<br/>';
                     $this->config['showErrors']['value']        = true;
                     $this->config['showDebug']['value']         = false;
                     $this->config['showAfterSuccess']['value']  = true;
                     $this->config['cleanAfterSuccess']['value'] = true;
                     $this->config['labelAfter']['value']        = ': ';
                     $this->config['submitField']['value']       = 'submit';
                     $this->config['html5']['value']             = false;
                     $this->config['placeholders']['value']      = false;
              }

              protected function getConfig($item): string
              {
                     if (isset($this->config[$item]['value'])) {
                            return $this->config[$item]['value'];
                     }
                     return false;
              }

              /*
               * @brief show debug information
               * @param $msg debug data
               */
              /**
               * @return bool
               */
              protected function debug(): bool
              {
                     return $this->getConfig('showDebug') ? true : false;
              }

              /**
               * @brief set config option
               *
               * @param  $option
               * @param  $value
               *
               * possible values:
               * {option <type> explanation (default value)[optionlist]}
               *
               * title <str> �������� �����
               * ���������������* name <str> ��� � ������������� �����
               * ���������������* act <str> �������� attr �����
               * ���������������* method <enum> ����� attr ����� (post) [get | �����]
               * ���������������* the class <str> ����� attr �����
               * ���������������* validator <str> ��� ����� ������ ���������� (Validator.php)
               * ���������������* validatorClass <str> ��� ������ ���������� (���������)
               * ���������������* sanitize <bool> ��������������� ���� (true)
               * ���������������* submitMessage <str> ���������, ������������ ��� �������� �������� (����� �������
               *        ����������!)
               * ���������������* submitField <str> ������������� ������ ��������
               * ���������������* showDebug <bool> ���������� ��������� �� �����������
               * ���������������* linebreaks <str>, ��� ������������ es linebreaks
               * ���������������* divs <bool> ������������ divs ��� ������������ ����� ������� � �����
               * ���������������* showErrors <bool> �������� ��������� �� ������� ��������
               * ���������������* errorTitle <str> �������� ������ ������
               * ���������������* errorLabel <str> ��������� ��� � ����� ������������� ����
               * ���������������* errorPosition <enum> ������� ��������� ���� � ������� [�� | ����� | in_before |
               *        in_after]
               * ���������������* (�before� � �after� �������� ���� ��� �������� �����, ��������� in_ * �������� ���
               *        ������)
               * ���������������* showAfterSuccess <bool> �������� ����� ����� �������� �������� (true)
               * ���������������* cleanAfterSuccess <bool> �������� ���� ����� �������� �������� (true)
               */
              public function set($option, $value): void
              {
                     try {
                            if (isset($this->config[$option])) {
                                   switch ($this->config[$option]['type']) {
                                          case 'str':
                                                 $this->config[$option]['value'] = $value;
                                                 break;
                                          case 'bool':
                                                 $this->config[$option]['value'] = $value;
                                                 break;
                                          case 'enum':
                                                 if (\in_array($value, $this->config[$option]['allowed'], true)) {
                                                        $this->config[$option]['value'] = $value;
                                                 } else {
                                                        throw new InvalidArgumentException('Value &quot;'.$value
                                                                                           .'&quot; is not allowed for &quot;'
                                                                                           .$option.'&quot;.');
                                                 }
                                                 break;
                                   }
                            } else {
                                   throw new InvalidArgumentException('&quot;'.$option.'&quot; is not an option.');
                            }
                     }
                     catch (LogicException $e) {
                            if ($this->debug()) {
                                   throw $e;
                            }
                     }
              }

              /**
               * @brief ������ ������ ����� �������� ��������
               */
              protected function saveValidInput(): void
              {
                     $this->valid_input = $this->input;
              }

              /**
               * @brief action on successful submit
               */
              protected function onSuccess(): void
              {
                     if ($this->getConfig('submitMessage') !== '') {
                            echo '<h2>'.$this->getConfig('submitMessage').'</h2>';
                     }
              }
              /*
               * @brief load data from array
               * @param $data associative array of data
               * @param $map field id mapping array
               */
              /**
               * @param      $data
               * @param bool $map
               */
              public function loadData($data, $map = false): void
              {
                     foreach ($data as $key => $value) {
                            if ($map) {
                                   $this->input[$map[$key]] = $value;
                            } else {
                                   $this->input[$key] = $value;
                            }
                     }
              }

              /*
               * @brief add submit button & display form
               * @param  $label label of submit button
               * @param  $id name attribute of submit button
               */
              /**
               * @param bool $label
               * @param bool $id
               * @param bool $aux
               *
               * @throws \RuntimeException
               */
              public function display($label = false, $id = false, $aux = false): void
              {
                     if ($id) {
                            $this->config['submitField']['value'] = $id;
                     }
                     $this->form =
                            "<form action='".$this->getConfig('action')."' method='".$this->getConfig('method')."' ";
                     if ($this->getConfig('name')) {
                            $this->form .= " name='".$this->getConfig('name')."' id='".$this->getConfig('name')."' ";
                     }
                     if ($this->getConfig('enctype')) {
                            $this->form .= " enctype='".$this->getConfig('enctype')."'";
                     }
                     if ($this->getConfig('class')) {
                            $this->form .= " class='".$this->getConfig('class')."'";
                     }
                     $this->form .= ">\n";
                     if ($this->getConfig('method') === 'get') {
                            $this->input =& $_GET;
                     } else {
                            $this->input =& $_POST;
                     }
                     foreach ($this->input as &$field) {
                            $field = $this->sanitize($field);
                     }
                     unset($field);
                     if ($this->protection_field) {
                            if (isset($this->input[$this->protection_field])) {
                                   $sent_code = $this->input[$this->protection_field];
                            } else {
                                   $sent_code = false;
                            }
                            $this->validator($this->protection_field, 'jsProtector', $sent_code,
                                             $this->protection_code);
                     }
                     $this->getFileInput();
                     $this->validateFields();
                     $this->writeErrors();
                     if ($this->getConfig('title')) {
                            $this->form .= '<fieldset><legend>'.$this->getConfig('title').'</legend>';
                     }
                     if ($this->getConfig('errorPosition') === 'in_before') {
                            $this->form .= $this->error_box;
                     }
                     if ($this->error === null && isset($this->input[$this->getConfig('submitField')])) {
                            $this->saveValidInput();
                            $this->onSuccess();
                            if ($this->getConfig('cleanAfterSuccess')) {
                                   unset ($this->input);
                                   $this->input[$this->getConfig('submitField')] = true;
                            }
                     }
                     if ($this->error !== null || $this->getConfig('showAfterSuccess')
                         || !isset($this->input[$this->getConfig('submitField')])) {
                            $this->groupClean();
                            $this->createFields();
                            if ($this->protection_code !== null) {
                                   $this->form .= "<input type='hidden' name='".$this->protection_field."' id='"
                                                  .$this->protection_field."' />";
                                   $this->form .= "<script type='text/javascript'>document.getElementById('"
                                                  .$this->protection_field."').value='"
                                                  .$this->protection_code."'</script>";
                            }
                            if ($id) {
                                   $this->form .= "<input type='submit' name='$id' value='$label' $aux />\n";
                            }
                            if ($this->getConfig('errorPosition') === 'in_after') {
                                   $this->form .= $this->error_box;
                            }
                            if ($this->getConfig('title')) {
                                   $this->form .= '</fieldset>';
                            }
                            $this->form .= "</form>\n";
                            if ($this->getConfig('errorPosition') === 'before') {
                                   $this->form = $this->error_box.$this->form;
                            }
                            if ($this->getConfig('errorPosition') === 'after') {
                                   $this->form .= $this->error_box;
                            }
                            echo $this->form;
                     }
              }
              /*
               * @brief generate FormField
               * @param $type type (text|textarea|radio|checkbox|select|file|hidden|password|submit|reset|button|image)
               * @param $id id
               * @param $label label
               * @param <bool> $mandatory mandatory
               * @param $init_value initial value for fields. Its format depends on the field type
               * @param $aux additional attributes (eg. rows, cols, maxlength, options etc.)
               *
               * ��� �����������, ������ � ������� ������� ������������� ������
���������������* ������ ���� ����� ��� �������� $aux(name => value).
               * ���� ������ ����� �������������� ��� �������� ������.
               */
              /**
               * @param      $type
               * @param      $id
               * @param      $label
               * @param bool $mandatory ������������
               * @param bool $init_value ��������� ������
               * @param bool $aux �������������� ��������
               */
              public function addField($type, $id, $label, $mandatory = false, $init_value = false, $aux = false): void
              {
                     $allowed = [
                            'text', 'textarea', 'radio', 'checkbox', 'select', 'file',
                            'hidden', 'password', 'submit', 'reset', 'button', 'image',
                            'number', 'date', 'month', 'week', 'time', 'datetime', 'datetime-local',
                            'email', 'url', 'range', 'color', 'search', 'time', 'tel',
                     ];
                     if ($type === 'submit' || 'image') {
                            $this->config['submitField']['value'] = $id;
                     }
                     if (!$init_value && isset($this->input[$id])) {
                            $init_value = $this->input[$id];
                     }
                     if (\in_array($type, $allowed, true)) {
                            $this->fields[$id] = [
                                   'type'       => $type, 'label' => $label, 'mandatory' => $mandatory,
                                   'init_value' => $init_value, 'aux' => $aux
                            ];
                     }
                     if ($type === 'file') {
                            $this->config['enctype']['value'] = 'multipart/form-data';
                     }
              }
              /*
               * @brief wrapping function for adding buttons
               * @param $type type of button
               * @param $id id & name of button
               * @param $value text of button
               */
              /**
               * @param      $type
               * @param      $id
               * @param      $value
               * @param bool $aux
               */
              public function button($type, $id, $value, $aux = false): void
              {
                     $this->addField($type, $id, false, false, $value, $aux);
              }
              /*
               * @brief acceskey for field
               * @param $field field name
               * @param $key acceskey value
               *
               * IMHO using accesskeys are not recommended as they may interfere with browser/textreader/etc. functions
               */
              /**
               * @param $field
               * @param $key
               */
              public function accesKey($field, $key): void
              {
                     $this->fields[$field]['acceskey'] = $key;
              }
              /*
               * @brief register validator function for field
               * @param $field fields id
               * @param $function name of validator function
               */
              /**
               * @param $field
               * @param $function
               *
               * @throws \RuntimeException
               */
              public function validator($field, $function): void
              {
                     try {
                            if ($this->form_validator === null) {
                                   $this->form_validator = false;
                                   $validatorClass       = $this->getConfig('validatorClass');
                                   if (class_exists($validatorClass)) {
                                          $this->form_validator = new $validatorClass;
                                   } else {
                                          throw new InvalidArgumentException('Validator ����� &quot;'
                                                                             .$this->getConfig('validatorClass')
                                                                             .'&quot; �� ������.');
                                   }
                            }
                            if ($function !== null && method_exists($this->form_validator, $function)) {
                                   $this->fields[$field]['validator'] = $function;
                                   $this->fields[$field]['args']      = \func_get_args();
                                   if (isset($this->input['pass'], $this->fields['pass']['args']['2'])) {
                                          $this->fields['pass']['args']['2'] = $this->input['pass'];
                                   }
                                   if (isset($this->input['pass2'], $this->fields['pass']['args']['3'])) {
                                          $this->fields['pass']['args']['3'] = $this->input['pass2'];
                                   }
                            } else {
                                   throw new InvalidArgumentException('����� &quot;'.$function.'&quot; �� ������.');
                            }
                     }
                     catch (LogicException $e) {
                            if ($this->debug()) {
                                   throw $e;
                            }
                     }
              }
              /*
               * @brief add text to form
               * @param $txt text
               */
              /**
               * @param $txt
               */
              public function addText($txt): void
              {
                     $this->fields[] = ['type' => 'auxtext', 'content' => '<p>'.$txt.'</p>'];
              }
              /*
               * @brief add custom item to form
               * @param $item item
               * @param $id id of item
              * @param $label label of item
               */
              /**
               * @param      $item
               * @param bool $id
               * @param bool $label
               */
              public function addItem($item, $id = false, $label = false): void
              {
                     $tmpitem = ['type' => 'auxitem', 'content' => $item, 'label' => $label];
                     if ($id) {
                            $this->fields[$id] = $tmpitem;
                     } else {
                            $this->fields[] = $tmpitem;
                     }
              }
              /*
               * @brief sets JS form protection
               * @param $code protection code
               *
               * ���� ����� �������� ������������� �������� ���� ������.
���������������* ��������� ������ js ��������� ������� ���� � �������� ����� ��������,
���������������* � ����� ��������� ���� ��� �� ��������. ��� ������������� �����
���������������* �������������� ������, �� ��������������� JS, �� ����� ����� �������������
���������������* ����������� �������������, ����� ������������ �������� JS.
               */
              /**
               * @param        $code
               * @param string $field
               */
              public function JSprotection($code, $field = 'prtcode'): void
              {
                     if ($code) {
                            $this->protection_code         = ' '.$code;
                            $this->protection_field        = $field;
                            $this->fields[$field]['label'] = 'JS Protection';
                     }
              }

              /**
               * @brief get the errors array
               */
              public function getErrors()
              {
                     return $this->error;
              }

              /**
               * @brief �������� ������ ������� ������
               * @return bool | array
               */
              public function getData()
              {
                     $values = $this->valid_input;
                     unset($values[$this->protection_field], $values[$this->getConfig('submitField')]);
                     return $values;
              }

              /**
               * @brief validate fields
               *
               * ����� �������� ������ ��������� ������, ���� ���� ���������, ����� �� ������ ������� ��������� ��
               *        ������
               */
              protected function validateFields(): void
              {
                     if ($this->fields) {
                            foreach ($this->fields as $id => $field) {
                                   if (isset($field['mandatory'])) {
                                          $mandatory = $field['mandatory'];
                                   } else {
                                          $mandatory = false;
                                   }
                                   if (isset($field['validator'])) {
                                          $validatorFunc = $field['validator'];
                                   } else {
                                          $validatorFunc = false;
                                   }
                                   if (isset($field['args'])) {
                                          $args = $field['args'];
                                   } else {
                                          $args = [];
                                   }
                                   if (isset($this->input[$this->getConfig('submitField')])) {
                                          //  $mandatory - ������������ �������� �� �������������� ������� ����
                                          if ($mandatory && isset($this->input[$id]) && $this->input[$id] === '') {
                                                 $this->errorRegistration($id);
                                          }
                                          if ($validatorFunc) {
                                                 if (isset($this->input[$id])) {
                                                        $value = $this->input[$id];
                                                 } else {
                                                        $value = false;
                                                 }
                                                 $this->errorRegistration($id,
                                                                          $this->form_validator->{$validatorFunc}($value,
                                                                                                                  \array_slice($args,
                                                                                                                               2)));
                                          }
                                   }
                            }
                     }
              }

              /**
               * @brief creates fields
               */
              protected function createFields(): void
              {
                     $type = $content = $grouped = $label = $acceskey = $mandatory = $init_value = $aux = null;
                     if ($this->fields) {
                            $props = [
                                   'type', 'label', 'content', 'acceskey', 'mandatory', 'init_value', 'aux',
                                   'validator', 'args', 'grouped'
                            ];
                            foreach ($this->fields as $id => $field) {
                                   foreach ($props as $prop) {
                                          if (isset($field[$prop])) {
                                                 ${$prop} = $field[$prop];
                                          } else {
                                                 ${$prop} = false;
                                          }
                                   }
                                   if ($type) {
                                          if (($type === 'auxtext') || ($type === 'auxitem')) {
                                                 $this->form .= $content;
                                          } else {
                                                 if ($type !== 'hidden' && $grouped <= 1 && $this->getConfig('divs')) {
                                                        $this->form .= '<div';
                                                        if (isset($this->error[$id]) && $this->error[$id]) {
                                                               $this->form .= " class='error'";
                                                        }
                                                        $this->form .= '>';
                                                 }
                                                 if ($label && ($type !== 'hidden')) {
                                                        $this->form .= '<label';
                                                        if ($type !== 'radio' && $type !== 'checkbox') {
                                                               $this->form .= " for='".$id."'";
                                                        }
                                                        if ($acceskey) {
                                                               $this->form .= " acceskey='".$acceskey."' ";
                                                        }
                                                        $this->form .= '>';
                                                        if (isset($this->error[$id]) && $this->error[$id]) {
                                                               $this->form .= $this->getConfig('errorLabel');
                                                        }
                                                        $this->form .= $label;
                                                        if ($mandatory) {
                                                               $this->form .= '*';
                                                        }
                                                        $this->form .= $this->getConfig('labelAfter')."</label>\n";
                                                 }
                                                 switch ($type) {
                                                        case 'text':
                                                        case 'number':
                                                        case 'date':
                                                        case 'month':
                                                        case 'week':
                                                        case 'time':
                                                        case 'datetime':
                                                        case 'datetime-local':
                                                        case 'email':
                                                        case 'url':
                                                        case 'range':
                                                        case 'color':
                                                        case 'search':
                                                        case 'tel':
                                                        case 'hidden':
                                                               $this->inputfield($id, $mandatory, $init_value, $aux,
                                                                                 $type, $label);
                                                               break;
                                                        case 'password':
                                                               $this->passwordfield($id, $mandatory, $init_value, $aux,
                                                                                    $label);
                                                               break;
                                                        case 'file':
                                                               $this->filefield($id, $aux);
                                                               break;
                                                        case 'textarea':
                                                               $this->textarea($id, $mandatory, $init_value, $aux,
                                                                               $label);
                                                               break;
                                                        case 'radio':
                                                               $this->radiobuttons($id, $mandatory, $init_value, $aux);
                                                               break;
                                                        case 'select':
                                                               $this->selectfield($id, $mandatory, $init_value, $aux);
                                                               break;
                                                        case 'checkbox':
                                                               $this->checkbox($id, $mandatory, $init_value, $aux);
                                                               break;
                                                        default:
                                                               $this->createButton($type, $id, $init_value, $aux);
                                                               break;
                                                 }
                                                 if ($type !== 'hidden' && (!$grouped || $grouped === 3)
                                                     && $this->getConfig('divs')) {
                                                        $this->form .= "</div>\n";
                                                 }
                                          }
                                   }
                            }
                     }
              }

              /*
               * @brief generate password field
               * @param $id id
               * @param <bool> $mandatory mandatory
               * @param <str> $init_value Initial value
               * @param $aux additional attributes (eg. maxlength)
               */
              /**
               * @param $id
               * @param $mandatory
               * @param $init_value
               * @param $aux
               * @param $label
               */
              protected function passwordfield($id, $mandatory, $init_value, $aux, $label): void
              {
                     $this->form .= "<input type='password' id='".$id."' name='".$id."' value='";
                     if (isset($this->input[$id])) {
                            $this->form .= $this->input[$id];
                     } elseif ($init_value) {
                            $this->form .= $init_value;
                     }
                     $this->form .= "' ".$aux.' ';
                     if ($mandatory && $this->getConfig('html5')) {
                            $this->form .= 'required ';
                     }
                     if ($this->getConfig('html5') && $this->getConfig('placeholders')) {
                            $this->form .= "placeholder='".$label."' ";
                     }
                     $this->form .= '/>';
                     if (!isset($this->fields[$id]['grouped']) || (!$this->fields[$id]['grouped'])
                         || ($this->fields[$id]['grouped'] === 3)) {
                            $this->form .= $this->getConfig('linebreaks');
                     }
                     $this->form .= "\n";
              }
              /*
               * @brief generate text field
               * @param $id id
               * @param <bool> $mandatory mandatory
               * @param <str> $init_value Initial value
               * @param $aux additional attributes (eg. maxlength)
               */
              /**
               * @param $id
               * @param $mandatory
               * @param $init_value
               * @param $aux
               * @param $type
               * @param $label
               */
              protected function inputfield($id, $mandatory, $init_value, $aux, $type, $label): void
              {
                     $has_placeholder = ['text', 'email', 'url', 'search', 'tel'];
                     $this->form      .= "<input type='".$type."' id='".$id."' name='".$id."' ";
                     if (isset($this->input[$id])) {
                            $this->form .= "value='".$this->input[$id]."' ";
                     } elseif ($init_value) {
                            $this->form .= "value='".$init_value."' ";
                     }
                     $this->form .= ' '.$aux.' ';
                     if ($mandatory && $this->getConfig('html5')) {
                            $this->form .= 'required ';
                     }
                     if ($this->getConfig('html5') && $this->getConfig('placeholders')
                         && \in_array($type, $has_placeholder, true)) {
                            $this->form .= "placeholder='".$label."' ";
                     }
                     $this->form .= '/>';
                     if (!isset($this->fields[$id]['grouped']) || !$this->fields[$id]['grouped']
                         || ($this->fields[$id]['grouped'] === 3)) {
                            $this->form .= $this->getConfig('linebreaks');
                     }
                     $this->form .= "\n";
              }
              /*
               * @brief generate file upload field
               * @param $id id
               * @param <bool> $mandatory ������������
               * @param $aux additional attributes (eg. accept)
               */
              /**
               * @param $id
               * @param $aux
               */
              protected function filefield($id, $aux): void
              {
                     $this->form .= "<input type='file' id='".$id."' name='".$id."' ".$aux.' />';
                     if (!isset($this->fields[$id]['grouped']) || (!$this->fields[$id]['grouped'])
                         || ($this->fields[$id]['grouped'] === 3)) {
                            $this->form .= $this->getConfig('linebreaks');
                     }
                     $this->form .= "\n";
              }

              /**
               * @todo documentation
               */
              protected function getFileInput(): void
              {
                     foreach ($_FILES as $id => $file) {
                            $this->input[$id] = $_FILES[$id];
                     }
              }

              /*
               * @brief generate textarea
               * @param $id id
               * @param <bool> $mandatory mandatory
               * @param <str> $init_value Initial value
               * @param $aux additional attributes (eg. rows, cols etc.)
               */
              /**
               * @param $id
               * @param $mandatory
               * @param $init_value
               * @param $aux
               * @param $label
               */
              protected function textarea($id, $mandatory, $init_value, $aux, $label): void
              {
                     $this->form .= "<textarea id='".$id."' name='".$id."' ";
                     $this->form .= $aux.' ';
                     if ($mandatory && $this->getConfig('html5')) {
                            $this->form .= 'required ';
                     }
                     if ($this->getConfig('html5') && $this->getConfig('placeholders')) {
                            $this->form .= "placeholder='".$label."' ";
                     }
                     $this->form .= '>';
                     if (isset($this->input[$id])) {
                            $this->form .= $this->input[$id];
                     } elseif ($init_value) {
                            $this->form .= $init_value;
                     }
                     $this->form .= '</textarea>';
                     if (!isset($this->fields[$id]['grouped'], $this->fields[$id]['grouped'])
                         || (!$this->fields[$id]['grouped'])
                         || ($this->fields[$id]['grouped'] === 3)) {
                            $this->form .= $this->getConfig('linebreaks');
                     }
                     $this->form .= "\n";
              }
              /*
               * @brief generate radiobuttons
               * @param $id id
               * @param <bool> $mandatory mandatory
               * @param <str> $init_value Initial value.
               * @param $options options array (name => value)
               */
              /**
               * @param $id
               * @param $mandatory
               * @param $init_value
               * @param $options
               */
              protected function radiobuttons($id, $mandatory, $init_value, &$options): void
              {
                     if (!$init_value) {
                            $tmpOpt     = array_values($options);
                            $init_value = $tmpOpt[0];
                     }
                     $this->form .= $this->config['linebreaks']['value']."\n";
                     if (!isset($this->fields[$id]['grouped']) || (!$this->fields[$id]['grouped'])
                         || ($this->fields[$id]['grouped'] === 3)) {
                            $this->form .= $this->getConfig('linebreaks');
                     }
                     echo "\n";
                     if ($mandatory && isset($this->input[$id]) && ($this->input[$id] === '')) {
                            $this->input[$id] = $options[key($options)];
                     }
                     $i = 1;
                     foreach ($options as $key => $value) {
                            $this->form .= "<label class='sublabel' for='".$id.'_'.$i."'><input type='radio' id = '".$id
                                           .'_'.$i."' name='".$id."' value='".$value
                                           ."' ";
                            if ((!isset($this->input[$id]) && ($init_value === $value))
                                || (isset($this->input[$id])
                                    && ($this->input[$id] === $value))) {
                                   $this->form .= "checked='checked' ";
                            }
                            $i++;
                            if ($mandatory && $this->getConfig('html5')) {
                                   $this->form .= 'required ';
                            }
                            $this->form .= ' />'.$key.'</label>';
                            if (!isset($this->fields[$id]['grouped']) || (!$this->fields[$id]['grouped'])
                                || ($this->fields[$id]['grouped'] === 3)) {
                                   $this->form .= $this->getConfig('linebreaks');
                            }
                            $this->form .= "\n";
                     }
              }
              /*
               * @brief generate select field
               * @param $id id
               * @param <bool> $mandatory mandatory
               * @param <str> $init_value Initial value
               * @param $options options array (name => value)
               */
              /**
               * @param $id
               * @param $mandatory
               * @param $init_value
               * @param $options
               */
              protected function selectfield($id, $mandatory, $init_value, &$options): void
              {
                     $this->form .= "<select id='".$id."' name='".$id."' ";
                     if ($mandatory && $this->getConfig('html5')) {
                            $this->form .= 'required ';
                     }
                     $this->form .= '>';
                     foreach ($options as $key => $value) {
                            $this->form .= "<option value='".$value."' ";
                            if ((isset($this->input[$id]) && ($this->input[$id] === $value))
                                || (!isset($this->input[$this->getConfig('submitField')])
                                    && ($init_value === $value))) {
                                   $this->form .= "selected='selected' ";
                            }
                            $this->form .= ' >'.$key."</option>\n";
                     }
                     $this->form .= '</select>';
                     if (!isset($this->fields[$id]['grouped']) || (!$this->fields[$id]['grouped'])
                         || ($this->fields[$id]['grouped'] === 3)) {
                            $this->form .= $this->getConfig('linebreaks');
                     }
                     $this->form .= "\n";
              }
              /*
               * @brief generate checkbox
               * @param $id id
               * @param $init_value boolean for a single field, comma separated values if an array was given for the $options parameter
               * @param <bool> $mandatory mandatory
               * @param $options options array (name => value)
               */
              /**
               * @param $id
               * @param $mandatory
               * @param $init_value
               * @param $options
               */
              protected function checkbox($id, $mandatory, $init_value, $options): void
              {
                     if (is_array($options)) {
                            $init_value = explode(',', str_replace(' ', '', $init_value));
                            $i          = 0;
                            foreach ($options as $key => $value) {
                                   $this->form .= "<label class='sublabel' for='".$id.'_'.$value
                                                  ."'><input type='checkbox' id='".$id.'_'.$value."' name='".$id.'_'
                                                  .$value."' ";
                                   $index      = $id.'_'.$value;
                                   if ((isset($this->input[$index]) && $this->input[$index])
                                       || (!isset($this->input[$this->getConfig('submitField')])
                                           && in_array($value, $init_value, true))) {
                                          $this->form .= " checked='checked' ";
                                   }
                                   $this->form .= ' />'.$key.'</label>';
                                   if (!isset($this->fields[$id]['grouped']) || (!$this->fields[$id]['grouped'])
                                       || ($this->fields[$id]['grouped'] === 3)) {
                                          $this->form .= $this->getConfig('linebreaks');
                                   }
                                   $this->form .= "\n";
                                   $i++;
                            }
                     } else {
                            if ($options) {
                                   $this->form .= "<label class='sublabel' for='".$id."'>";
                            }
                            $this->form .= "<input type='checkbox' id='".$id."' name='".$id."' ";
                            if ((isset($this->input[$id])
                                 && (($this->input[$id] === '1')
                                     || ($this->input[$id] === 'on')))
                                || (!isset($this->input[$this->getConfig('submitField')]) && $init_value)) {
                                   $this->form .= " checked='checked' ";
                            }
                            if ($mandatory && $this->getConfig('html5')) {
                                   $this->form .= 'required ';
                            }
                            $this->form .= ' />';
                            if ($options) {
                                   $this->form .= $options.'</label>';
                            }
                            if (!isset($this->fields[$id]["grouped"]) || (!$this->fields[$id]['grouped'])
                                || ($this->fields[$id]['grouped'] === 3)) {
                                   $this->form .= $this->getConfig('linebreaks');
                            }
                            $this->form .= "\n";
                     }
              }

              protected function createButton($type, $id, $value, $aux): void
              {
                     $allowed = ['submit', 'reset', 'button', 'image'];
                     if (in_array($type, $allowed, true)) {
                            $this->form .= "<input type='".$type."' id='".$id."' name='".$id."' value='".$value."' "
                                           .$aux.' />';
                            $this->form .= $this->getConfig('linebreaks');
                     }
              }
              /*
               * @brief sanitize input text
               *
               * @param $str text to clean
               * @return cleaned text
               */
              /**
               * @param $str
               *
               * @return string
               */
              protected function sanitize($str): string
              {
                     if (\is_string($str) && ($this->getConfig('sanitize') === true)) {
                            $str = $this->getFormValue($str);
                     }
                     return $str;
              }

              /**
               * @param      $in_Val
               * @param int  $trim_Val
               * @param bool $u_Case
               * @param bool $trim_symbols
               *
               * @return bool|string
               */
              protected function getFormValue($in_Val, $trim_Val = 0, $u_Case = false, $trim_symbols = false): string
              {
                     $ret = trim(htmlspecialchars(strip_tags($in_Val), ENT_HTML5, CHARSET));
                     if ($trim_Val) {
                            $ret = substr($ret, 0, $trim_Val);
                     }
                     if ($u_Case) {
                            $ret = strtoupper($ret);
                     }
                     // ������� ������ ����� �� ������ ��������
                     // ������: $ret = 12345test; �� ������ 12345
                     if ($trim_symbols) {
                            $my_len = \strlen($ret);
                            for ($pos = 0; $pos < $my_len; $pos++) {
                                   if (!is_numeric($ret[$pos])) {
                                          $ret = substr($ret, 0, $pos);
                                          break;
                                   }
                            }
                     }
                     return $ret;
              }

              /**
               * @param        $field
               * @param string $msg
               * @param string $input
               */
              protected function errorRegistration($field, $msg = '������ ����')
              {
                     if ($msg !== false && $msg !== null) {
                            $this->error[$field]['msg']  = $this->fields[$field]['label'].': '.$msg;
                            $this->error[$field]['link'] = $field;
                     }
              }

              /**
               * @brief display error list
               */
              protected function writeErrors()
              {
                     if ($this->error && $this->config['showErrors']['value']) {
                            $this->error_box = '<div class="errorbox">';
                            if ($this->config['errorTitle']['value']) {
                                   $this->error_box .= '<h4 style="color: #c95030; text-shadow: none;">'
                                                       .$this->config['errorTitle']['value']."</h4>\n";
                            }
                            $this->error_box .= "<ul id='errorList'>\n";
                            foreach ($this->error as $error) {
                                   $this->error_box .= "<li><label for='".$error['link']."'>".$error['msg']
                                                       ."</label></li>\n";
                            }
                            $this->error_box .= "</ul></div>\n";
                     }
              }
              /*
               * @brief join selected fields
               * @param ids of fields to join
               */
              /**
               *
               */
              public function join()
              {
                     $this->has_groups = true;
                     $args             = \func_get_args();
                     foreach ($args as $arg) {
                            $this->fields[$arg]['grouped'] = true;
                     }
              }

              /**
               * @brief cleans joined groups
               *
               * field['grouped']:   0: nogroup, 1:start, 2:middle, 3:end
               */
              protected function groupClean()
              {
                     $prev = null;
                     if ($this->has_groups) {
                            foreach ($this->fields as &$item) {
                                   if (isset($item['grouped']) && $item['grouped'] > 0) {
                                          $item['grouped'] = 1;
                                   }
                                   if (isset($item['grouped'], $prev['grouped']) && $item['grouped'] === 1
                                       && $prev['grouped']) {
                                          $item['grouped'] = 2;
                                   }
                                   if ((!isset($item['grouped']) || $item['grouped'] === 0)
                                       && (isset($prev['grouped'])
                                           && $prev['grouped'] > 1)) {
                                          $prev['grouped'] = 3;
                                   }
                                   if (isset($item['grouped'], $prev['grouped']) && $item['grouped'] === 0
                                       && $prev['grouped'] === 1) {
                                          $prev['grouped'] = false;
                                   }
                                   $prev =& $item;
                            }
                     }
              }
       }
