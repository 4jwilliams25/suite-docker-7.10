{* Links the JS file to this tpl *}
<script src='{sugar_getjspath file="custom/include/SugarFields/Fields/Tagselect/Tagselect.js"}'></script>

{* Not sure if this actually does anything, I think it might have something to do with loading values *}
{if strlen({{sugarvar key='value' string=true}}) <= 0}
    {assign var="value" value={{sugarvar key='default_value' string=true}} }
{else}
    {assign var="value" value={{sugarvar key='value' string=true}} }
{/if}
{* Assigns varibles to the _tpl_vars array for use within the file *}
{assign var="existingTags" value=","|explode:$value}
{assign var="tagNames" value={{$tagNames}}}
{assign var="tagIds" value={{$tagIds}}}
{* The inputs *}
<div id='tagDiv'>
    {* Hidden inputs to store variables for access by the JS file *}
    <input 
        type='hidden' 
        name='tags_c'
        id='tags_c'
        value='{{sugarvar key='value'}}' 
    />
    <input type='hidden' value='{{$tagNames}}' id='tagNames' /> 
    <input type='hidden' value='{{$tagIds}}' id='tagIds' /> 
    {* The functional input to add a new tag *}
    <label id='tagError' style='display:none; color:red'>Invalid Tag</label>
    <input type='text' onclick = 'doAutoComplete({{$tagNames}})' id='tagInput' autocomplete='on' />
    <button 
        type="button" 
        class="btn btn-danger email-address-add-button" 
        title="{$app_strings.LBL_ID_FF_ADD_EMAIL} " {$other_attributes}
        onclick=addTag()
    >
        <span class="suitepicon suitepicon-action-plus"></span>
    </button>

    {* PHP to handle displaying tags already related to the record that can be removed *}
    {php}
        global $current_user;

        if(!empty($this->_tpl_vars['existingTags'][0])) {
            {* Pull the currently related tags, array of all tag names, and array of all tag ids from the _tpl_vars and convert to usable arrays *}
            $existingTags = $this->_tpl_vars['existingTags'];
            $tagNames = json_decode($this->_tpl_vars['tagNames']);
            $tagIds = json_decode($this->_tpl_vars['tagIds']);

            {* For each currently related tag, find it's index within the array of all tag ids, then create a disabled input who's value is that index in the array of all tag names *}
            foreach ($existingTags as $tag) {
                $tagIndex = array_search($tag, $tagIds);
                echo "
                <input 
                    type='text' 
                    id='{$tag}_input' 
                    value='$tagNames[$tagIndex]' 
                    disabled
                >
                <button 
                    id='{$tag}_remove' 
                    type='button' 
                    class='btn btn-danger' 
                    onclick=removeTag('{$tag}') 
                    title='RemoveTag'
                >
                    <span class='suitepicon suitepicon-action-minus'></span>
                </button>";
            }
        };
    {/php}
    
</div>