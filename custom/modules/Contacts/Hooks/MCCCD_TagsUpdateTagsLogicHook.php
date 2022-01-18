<?php

require_once "custom/include/SugarFields/Fields/Tagselect/SugarFieldTagselect.php";
require_once "include/database/MysqliManager.php";
require_once "data/SugarBean.php";

class MCCCD_TagsUpdateTagsLogicHook
{
    public function updateTags($bean, $event, $arguments)
    {
        // Takes the input tag ID string from the hidden field and turns it into an array
        $tagIds = explode(",", $bean->tags_c);
        LoggerManager::getLogger()->fatal(print_r($tagIds, 1));

        if ($this->verifyTags($tagIds)) {
            // Remove the tags from the bean so they are not saved
            unset($bean->tags_c);

            // Add an error message to the next page
            SugarApplication::appendErrorMessage('Error: Provided tags were invalid and were not saved');

            // Redirect back to edit view
            SugarApplication::redirect("index.php?action=EditView&module=" . $bean->module_dir . "&record=" . $bean->id . "&offset=1");

            // End Logic Hook
            return;
        }

        // Pull the specific bean currently being worked on
        $contactBean = BeanFactory::getBean('Contacts', $bean->id);

        // Pulls all tags related to the current bean into an array
        $currentTags = $contactBean->get_linked_beans(
            'mcccd_tags_contacts_1',
            'MCCCD_Tags',
        );

        // Loads the tag relationship for this bean so we can modify it
        $contactBean->load_relationship(('mcccd_tags_contacts_1'));

        // Loops through all the related tags currently in the db, for each one it checks if that tag is in the input, and if it isn't it marks it deleted in the db
        foreach ($currentTags as $currentTag) {
            foreach ($tagIds as $inputTag) {
                if (!in_array($currentTag->id, $tagIds)) {
                    $contactBean->mcccd_tags_contacts_1->delete($contactBean->id, $currentTag);
                }
            }
        }

        // Converts the currently related tags in the db into an array of ID's
        $currentTagIds = array();
        foreach ($currentTags as $currentTag) {
            array_push($currentTagIds, $currentTag->id);
        }

        // Loops through the tag id's in the input, for each one it checks to see if is already one of the related id's in the db, if not it adds it
        foreach ($tagIds as $inputTag) {
            if (!in_array($inputTag, $currentTagIds)) {
                $updatedRow = $this->updateRelationshipTable($inputTag, $contactBean->id);
                if (!$updatedRow) {
                    $contactBean->mcccd_tags_contacts_1->add($inputTag);
                }
            }
        }
    }

    public function verifyTags($tagIds)
    {
        // Get existing valid tags from the DB
        $sugarField = new SugarFieldTagselect('Contact');
        $existingTags = $sugarField->getTagList();

        // Set return bool
        $badTags = false;

        // If there are no tags return bool
        if (empty($tagIds[0])) {
            return $badTags;
        }

        foreach ($tagIds as $tag) {
            // Ensure all the tags exist in the DB
            if (!array_key_exists($tag, $existingTags)) {
                $badTags = true;
                // break as soon as you find an error
                break;
            }
        }

        return $badTags;
    }

    public function updateRelationshipTable($tagId, $contactId)
    {
        $db = new MysqliManager;
        $sql = "UPDATE mcccd_tags_contacts_1_c 
        SET deleted = 0
        WHERE mcccd_tags_contacts_1contacts_idb = '{$contactId}'
        AND  mcccd_tags_contacts_1mcccd_tags_ida  = '{$tagId}'";

        $results = $db->query($sql);
        $UpdatedCount = $db->getAffectedRowCount($results);

        LoggerManager::getLogger()->fatal(print_r($results, 1));
        LoggerManager::getLogger()->fatal("Updated Rows: {$UpdatedCount}");

        return $UpdatedCount;
    }
}
