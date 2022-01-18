<?php

// Extension of class MassUpdate to allow MassUpdate of field of type TextArea

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('include/MassUpdate.php');
require_once "custom/include/SugarFields/Fields/Tagselect/SugarFieldTagselect.php";

class CustomMassUpdate extends MassUpdate
{

    /**
     * Override of this method to allow MassUpdate of field of type Tagselect
     * @param string $displayname field label
     * @param string $field field name
     * @param bool $even even or odd
     * @return string html field data
     */
    protected function addDefault($displayname, $field, &$even)
    {
        if ($field["type"] == 'Tagselect') {
            // Get existing valid tags from the DB
            $sugarField = new SugarFieldTagselect('Contact');
            $existingTags = $sugarField->getTagList();
            $jsonTags = json_encode($existingTags);
            $jsonValues = json_encode(array_values($existingTags));
            $jsonKeys = json_encode(array_keys($existingTags));

            $even = !$even;
            $varname = $field["name"];
            $displayname = addslashes($displayname);
            $html = <<<EOQ
                        <script type="text/javascript">;

                            function doMassAutoComplete() {

                                $("#massTagInput").autocomplete({
                                    source: {$jsonValues},
                                    appendTo: $("massTagInput").val(),
                                });
                            }

                            function showMassTagError() {
                                document.getElementById("massTagError").style.display = "block";
                              
                                setTimeout(function () {
                                  document.getElementById("massTagError").style.display = "none";
                                }, 2000);
                              }

                            function selectMassTag() {
                                let tag = $("#massTagInput").val().toLowerCase();
                                let existingTags = {$jsonValues}.map(value => value = value.toLowerCase());

                                if (!existingTags.includes(tag)) {
                                    $("#massTagInput").val("");
                                    $("#mass_{$varname}").val("");
                                    showMassTagError();
                                    return false;
                                } else {
                                    let index = existingTags.indexOf(tag);
                                    let tagsId = {$jsonKeys}[index];
                                    $("#mass_{$varname}").val(tagsId);
                                    return true;
                                }
                              }
                        </script>
                        <div id="massTagDiv">
                            <td scope="row" width="20%">$displayname</td>
                            <td class="dataField" width="30%">
                                <label id='massTagError' style='display:none; color:red'>Invalid Tag</label>
                                <input 
                                    type="text" 
                                    name="massTagInput" 
                                    style="width: 70%;" 
                                    id="massTagInput" 
                                    onclick="doMassAutoComplete()"      
                                    autocomplete="off"
                                    onfocusout="selectMassTag()"
                                />
                                <input 
                                    type="hidden"
                                    name="$varname"
                                    id="mass_{$varname}"  
                                />
                            </td>
                        <div>
                    EOQ;
            return $html;
        } else
            return '';
    }
}
