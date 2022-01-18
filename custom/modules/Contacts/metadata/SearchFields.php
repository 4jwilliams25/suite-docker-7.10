<?php
// created: 2021-11-10 21:37:37
$searchFields['Contacts'] = array(
  'mcccd_tags' =>
  array(
    'query_type' => 'format',
    'operator' => 'subquery',
    'subquery' => '
        SELECT
            mcccd_tags_contacts_1_c.mcccd_tags_contacts_1contacts_idb 
        FROM
            mcccd_tags_contacts_1_c, mcccd_tags
        WHERE
            mcccd_tags.name IN ("{0}") AND mcccd_tags.id = mcccd_tags_contacts_1_c.mcccd_tags_contacts_1mcccd_tags_ida AND mcccd_tags_contacts_1_c.deleted = 0',
    'db_field' =>
    array(
      0 => 'id',
    ),
  ),
  'range_date_entered' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_entered' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_entered' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'range_date_modified' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_modified' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_modified' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
);
