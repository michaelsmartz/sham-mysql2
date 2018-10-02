<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'forms';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title',
                  'description',
                  'sata'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function getFormKeys() {

        if (!isset ($this->sata)) return array();
        $array = json_decode($this->sata,TRUE);
        return self::NodesToArrayKeys($array);

    }

    /**
     * set of nodes making up the form
     * @param $nodes
     * @return array
     */
    private function NodesToArrayKeys($nodes)
    {
        $retval = array();

        // dump($nodes);
        // die;

        foreach ($nodes as $node)
        {

            if (array_key_exists('type',$node))
            {
                switch($node['type'])
                {
                    case "fieldset":
                    case "form_fieldset":
                    case 'button':
                    case 'form_button':
                    case 'fileupload':
                    case 'form_fileupload':
                    case 'separator':
                    case 'form_separator':
                    case 'image':
                    case 'form_image':
                        //IGNORE
                        break;

                    case 'checkbox':
                    case 'form_checkbox':
                    case 'textarea':
                    case 'form_textarea':
                    case 'text':
                    case 'form_text':
                    case 'paragraph':
                    case 'form_paragraph':
                        //Take value
                        if (array_key_exists('name',$node)){
                            $retval[$node['name']] = (array_key_exists('label', $node)? $node['label'] : '');
                        }

                        break;
                    case 'select':
                    case 'form_select':
                        if (array_key_exists('name',$node)){
                            $retval[$node['name']] = (array_key_exists('label', $node)? $node['label'] : '');
                        }
                    case 'radio':
                    case 'form_radio':
                    case 'multiple-choice':
                    case 'form_multiplechoice':
                        //take selected option
                        if (array_key_exists('name',$node)){
                            $retval[$node['name']] = (array_key_exists('label', $node)? $node['label'] : '');
                        }

                }
                if (array_key_exists('children',$node))
                {
                    $retval1 = self::NodesToArrayKeys($node['children']);
                    foreach($retval1 as $key =>$value)
                    {
                        $retval[$key] = $value;
                    }
                }
            }
        }

        return $retval;

    }


}
