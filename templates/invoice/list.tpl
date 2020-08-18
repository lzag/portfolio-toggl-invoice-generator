{include file="{$header}"}
<div class="row">
{foreach from=$invoices item=$invoice}
<div id="invoicecard{$invoice->id}" class="card invoiceDetails" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">ID {$invoice->id} from {$invoice->invoice_date}</h5>
    <h6 class="card-subtitle mb-2 text-muted">{$invoice->client_name}</h6>
    <p class="card-text">Services from {$invoice->start_date} to {$invoice->end_date}</p>

    <a href="invoice/download/{$invoice->filename}" class="card-link">See invoice</a>
    <a invoiceid= {$invoice->id} href="invoice/delete/{$invoice->id}" class="card-link deleteInvoiceLink" >Delete invoice</a>
  </div>
</div>
{/foreach}
</div>

<!-- Confirmation Modal -->
<div id="deleteConfirmationModal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm invoice deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete the invoice?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="confirmDeleteButton" type="button" class="btn btn-primary">Confirm delete</button>
      </div>
    </div>
  </div>
</div>

{include file="{$footer}"}
<script type="text/javascript">
{include file="{PROJECT_DIR}/templates/invoice/list.js.tpl"}
</script>
