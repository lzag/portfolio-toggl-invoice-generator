{include file="{$header}"}

<div class="container">
  <div id="form-alert"></div>
  <form class="form-horizontal row g-3" method="POST" action="#" id="invoiceForm">
    <div class="col-md-4">
      <label for="fromDate" class="form-label"><strong>From date</strong></label>
      <input type="date" class="form-control" id="fromDate" name="fromDate">
    </div>
    <div class="col-md-4">
      <label for="toDate" class="form-label"><strong>To date:</strong></label>
      <input type="date" class="form-control" id="toDate" name="toDate">
    </div>
    <div class="col-md-4">
      <label for="client" class="form-label"><strong>Client:</strong></label>
      <input type="text" class="form-control" id="client" name="client">
    </div>
    <div class="col-md-3">
      <button id="getInvoiceData" class="btn btn-primary">Get Services</button> 
      <button id="generateInvoice" class="btn btn-secondary" disabled>Generate Invoice</button> 
    </div>
    <hr>
    <div class="form-group row mt-3">
      <div class="form-group col">
      <label for="invoice_date" class="form-label"><strong>Invoice date:</strong></label>
        <input type="date" class="form-control" name="invoice_date" value="{$invoice_date|default: $invoice_date}" />
      </div>
      <div class="form-group col">
        <label for="invoice_due" class="form-label"><strong>Invoice due:</strong></label>
        <input type="date" class="form-control" name="invoice_due" value="{$invoice_due|default: $invoice_date}" />
      </div>
      <div class="form-group col">
        <label for="rate" class="form-label"><strong>Rate</strong></label>
        <input type="text" class="form-control" name="rate" value="13.40" />
      </div>
      <div class="form-group col">
        <label for="invoice_no" class="form-label"><strong>Invoice no:</strong></label>
        <input type="text" class="form-control" name="invoice_no" value="{$invoice_no|default: ''}" />
      </div>
    </div>
    <hr>
    <div id="client_info" class="col-md-4">
    </div>
    <div id="my_info" class="col-md-4">
    </div>
    <div id="bank_info" class="col-md-4">
    </div>
    <div id="services" class="col-md-12">
    </div>
  </form>

</div>



Rate:

Services:


Subtotal:

Tax Total:

Total:

Bank Data:

{include file="{PROJECT_DIR}/templates/invoice/new.js.tpl"}
{include file="{$footer}"}
