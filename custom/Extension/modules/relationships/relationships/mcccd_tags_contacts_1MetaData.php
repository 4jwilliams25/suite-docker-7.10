<?php
// created: 2021-08-27 17:13:19
$dictionary["mcccd_tags_contacts_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'mcccd_tags_contacts_1' => 
    array (
      'lhs_module' => 'MCCCD_Tags',
      'lhs_table' => 'mcccd_tags',
      'lhs_key' => 'id',
      'rhs_module' => 'Contacts',
      'rhs_table' => 'contacts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'mcccd_tags_contacts_1_c',
      'join_key_lhs' => 'mcccd_tags_contacts_1mcccd_tags_ida',
      'join_key_rhs' => 'mcccd_tags_contacts_1contacts_idb',
    ),
  ),
  'table' => 'mcccd_tags_contacts_1_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'mcccd_tags_contacts_1mcccd_tags_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'mcccd_tags_contacts_1contacts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'mcccd_tags_contacts_1spk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'mcccd_tags_contacts_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'mcccd_tags_contacts_1mcccd_tags_ida',
        1 => 'mcccd_tags_contacts_1contacts_idb',
      ),
    ),
  ),
);