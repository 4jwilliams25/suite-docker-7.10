<script src='{sugar_getjspath file="custom/include/SugarFields/Fields/Tagsearch/Tagsearch.js"}'></script>

{* Initializes values existing in the custom tables *}
{if strlen({{sugarvar key='value' string=true}}) <= 0}
    {assign var="value" value={{sugarvar key='default_value' string=true}} }
{else}
    {assign var="value" value={{sugarvar key='value' string=true}} }
{/if}

{* Load tag information *}
{assign var="existingTags" value=","|explode:$value}
{assign var="tagNames" value={{$tagNames}}}
{assign var="tagIds" value={{$tagIds}}}

{* Create tag HTML *}
<div id='tagDiv'>
    <input 
        type='hidden' 
        name='mcccd_tags'
        id='mcccd_tags'
        value='{{sugarvar key='value'}}' 
    />
    <input type='hidden' value='{{$tagNames}}' id='tagNames' /> 
    <input type='hidden' value='{{$tagIds}}' id='tagIds' /> 

    <label id="tagError" style ="display:none; color:red"></label>
    <input type='text' onclick = 'doAutoComplete({{$tagNames}})' id='tagInput' autocomplete='off'/>
    <button 
        type="button" 
        class="btn btn-danger email-address-add-button" 
        title="{$app_strings.LBL_ID_FF_ADD_EMAIL} " {$other_attributes}
        onclick=addTag()
    >
        <span class="suitepicon suitepicon-action-plus"></span>
    </button>

{* This PHP builds entries into the Tag Div for existing tags *}
    {php}
        global $current_user;
        if(!empty($this->_tpl_vars['existingTags'][0])) 
        {
            $existingTags = $this->_tpl_vars['existingTags'];
            $tagNames = json_decode($this->_tpl_vars['tagNames']);
            $tagIds = json_decode($this->_tpl_vars['tagIds']);
            
            foreach ($existingTags as $tag) {

                $tagIndex = array_search($tag, $tagNames);
                $UCTagName = ucwords($tag);
                $tagID = $tagIds[$tagIndex];

                echo "<input type='text' id='{$tagID}_input' value='$UCTagName' disabled><button id='{$tagID}_remove' type='button' onclick=removeTag('{$tagID}') class='btn btn-danger' title='RemoveTag'><span class='suitepicon suitepicon-action-minus'></span></button>";
                
            }

            
        }
    {/php}
    
</div>