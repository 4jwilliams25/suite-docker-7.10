<?php
// Extension of classe ListView to allow MassUpdate of field of type TextArea

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/include/CustomListViewSmarty.php');

class ContactsViewList extends ViewList
{
    function preDisplay()
    {
        $this->lv = new CustomListViewSmarty();
    }
}
