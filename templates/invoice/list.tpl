{include file="{$header}"}
<div class="row">
{foreach from=$invoices item=$invoice}
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">ID {$invoice->id} from {$invoice->invoice_date}</h5>
    <h6 class="card-subtitle mb-2 text-muted">{$invoice->client_name}</h6>
    <p class="card-text">Services from {$invoice->start_date} to {$invoice->end_date}</p>

    <a href="invoice/download/{$invoice->filename}" class="card-link">See invoice</a>
  </div>
</div>
{/foreach}
</div>

{include file="{$footer}"}
