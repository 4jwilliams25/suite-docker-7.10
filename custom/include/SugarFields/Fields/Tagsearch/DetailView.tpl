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

{* This PHP builds entries into the Tag Div for existing tags *}
{php}
    global $current_user;

    if(!empty($this->_tpl_vars['existingTags'][0])) {
        $existingTags = $this->_tpl_vars['existingTags'];
        $tagNames = json_decode($this->_tpl_vars['tagNames']);
        $tagIds = json_decode($this->_tpl_vars['tagIds']);

        foreach ($existingTags as $tag) {
            $tagIndex = array_search($tag, $tagIds);
            echo "<span class='sugar_field'>{$tagNames[$tagIndex]}</span><br>";
        }
    }
{/php}
