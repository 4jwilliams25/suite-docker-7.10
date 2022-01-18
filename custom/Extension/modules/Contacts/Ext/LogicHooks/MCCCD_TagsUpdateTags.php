<?php

$hook_array['before_save'][] = array( // Type
    1, // hook index
    'updateTags', // description
    'custom/modules/Contacts/Hooks/MCCCD_TagsUpdateTagsLogicHook.php', // hook file location
    'MCCCD_TagsUpdateTagsLogicHook', // hook class
    'updateTags' // hook method
);
