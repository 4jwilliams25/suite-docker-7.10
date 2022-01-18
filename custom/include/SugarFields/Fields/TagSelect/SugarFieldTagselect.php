<?php

require_once 'include/SugarFields/Fields/Base/SugarFieldBase.php';
require_once 'data/SugarBean.php';


class SugarFieldTagselect extends SugarFieldBase
{
    //Returns a list of all existing Tags
    public function getTagList()
    {
        //Create empty tag bean
        $tagBean = BeanFactory::getBean('MCCCD_Tags');

        //get full list of tag beans
        $tagList = $tagBean->get_full_list(
            $order_by = "",
            $where = "",
            $check_dates = false,
            $show_deleted = 0
        );

        $existingTags =  array();

        //Load tag names from the bean into an array
        for ($i = 0; $i < count($tagList); $i++) {
            $existingTags[$tagList[$i]->id] = $tagList[$i]->name;
        }

        return $existingTags;
    }

    /**
     * Setup function to assign values to the smarty template, should be called before every display function
     * @param $parentFieldArray
     * @param $vardef
     * @param $displayParams
     * @param $tabindex
     * @param bool $twopass
     */
    public function setup($parentFieldArray, $vardef, $displayParams, $tabindex, $twopass = true)
    {

        //enable smarty controls
        $this->button = '';
        $this->buttons = '';
        $this->image = '';
        if ($twopass) {
            $this->ss->left_delimiter = '{{';
            $this->ss->right_delimiter = '}}';
        } else {
            $this->ss->left_delimiter = '{';
            $this->ss->right_delimiter = '}';
        }

        //Get tag lists and make it a json object
        $tagList = $this->getTagList();

        //Bust the tag list into key and  value arrays (this saves us some time in the logic hook)
        $jsonTagIds = json_encode(array_keys($tagList));
        $jsonTagNames = json_encode(array_values($tagList));


        //Create smarty variables
        $this->ss->assign('parentFieldArray', $parentFieldArray);
        $this->ss->assign('vardef', $vardef);
        $this->ss->assign('tabindex', $tabindex);
        $this->ss->assign('tagIds', $jsonTagIds);
        $this->ss->assign('tagNames', $jsonTagNames);

        //for adding attributes to the field

        if (!empty($displayParams['field'])) {
            $plusField = '';
            foreach ($displayParams['field'] as $key => $value) {
                $plusField .= ' ' . $key . '="' . $value . '"'; //bug 27381
            }
            $displayParams['field'] = $plusField;
        }
        //for adding attributes to the button
        if (!empty($displayParams['button'])) {
            $plusField = '';
            foreach ($displayParams['button'] as $key => $value) {
                $plusField .= ' ' . $key . '="' . $value . '"';
            }
            $displayParams['button'] = $plusField;
            $this->button = $displayParams['button'];
        }
        if (!empty($displayParams['buttons'])) {
            $plusField = '';
            foreach ($displayParams['buttons'] as $keys => $values) {
                foreach ($values as $key => $value) {
                    $plusField[$keys] .= ' ' . $key . '="' . $value . '"';
                }
            }
            $displayParams['buttons'] = $plusField;
            $this->buttons = $displayParams['buttons'];
        }
        if (!empty($displayParams['image'])) {
            $plusField = '';
            foreach ($displayParams['image'] as $key => $value) {
                $plusField .= ' ' . $key . '="' . $value . '"';
            }
            $displayParams['image'] = $plusField;
            $this->image = $displayParams['image'];
        }
        $this->ss->assign('displayParams', $displayParams);
    }
}
