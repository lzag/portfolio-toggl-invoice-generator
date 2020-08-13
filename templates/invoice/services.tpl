{if empty($projects) eq true}
  <h4>No billable projects found for {$client} in the specified dates</h4>
{else}
  <h4>Services from <strong>{$start_date}</strong> to <strong>{$end_date}</strong> for <strong>{$client}</strong></h4>
  <h5>Total billable hours: {$total_hours}
  <hr>
  {foreach from=$projects item=$project key=$key}
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{$project->getTitle()}</h5>
        <h6 class="card-subtitle mb-2 text-muted">
          {$project->getTotalHours()}
          {if $project->getTotalHours() lt 2} hour
          {else} hours
          {/if}
        </h6>
      </div>
      <ul id="project-{$key}"class="list-group list-group-flush">
        {foreach $project->getEntries() item=$entry}
          <li class="list-group-item project-{$key}-entry">
          {$entry}
          </li>
        {/foreach}
      </ul>
    </div>
  {/foreach}
{/if}
