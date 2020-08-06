{foreach from=$projects item=$project}
  <h4>{$project->getTitle()}</h4>
  <ul>
    {foreach $project->getEntries() item=$entry}
    <li>
    {$entry}
    </li>
    {/foreach}
  </ul>
{/foreach}
