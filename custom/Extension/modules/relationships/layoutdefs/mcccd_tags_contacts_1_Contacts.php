<?php
 // created: 2021-08-27 17:13:19
$layout_defs["Contacts"]["subpanel_setup"]['mcccd_tags_contacts_1'] = array (
  'order' => 100,
  'module' => 'MCCCD_Tags',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_MCCCD_TAGS_CONTACTS_1_FROM_MCCCD_TAGS_TITLE',
  'get_subpanel_data' => 'mcccd_tags_contacts_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
