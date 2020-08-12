{if empty($projects) eq true}
  <h4>No billable projects found for {$client} in the specified dates</h4>
{else}
  <h4>Services from <strong>{$start_date}</strong> to <strong>{$end_date}</strong> for <strong>{$client}</strong></h4>
  <h5>Total billable hours: {$total_hours}
  <hr>
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
{/if}
