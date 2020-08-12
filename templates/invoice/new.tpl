{include file="{$header}"}

<div class="container">
  <form class="form-horizontal row g-3" method="POST" action="#" id="invoiceForm">
    <div class="col-md-4">
      <label for="fromDate" class="form-label">From date</label>
      <input type="date" class="form-control" id="fromDate">
    </div>
    <div class="col-md-4">
      <label for="toDate" class="form-label">To date:</label>
      <input type="date" class="form-control" id="toDate">
    </div>
    <div class="col-md-4">
      <label for="client" class="form-label">Client:</label>
      <input type="text" class="form-control" id="client">
    </div>
    <div class="col-md-3">
      <button id="getInvoiceData" class="btn btn-primary">Get Services</button> 
      <button id="generateInvoice" class="btn btn-secondary" disabled>Generate Invoice</button> 
    </div>
    <div class="form-group row mt-3">
      <label class="col-sm-2" for="invoice_date" class="form-label">Invoice date:</label>
      <div class="col">
        <input class="form-control" name="invoice_date" value="{$invoice_date|default: ''}" />
      </div>
      <label class="col-sm-2" for="invoice_due" class="form-label">Invoice due:</label>
      <div class="col">
        <input class="form-control" name="invoice_due" value="{$invoice_due|default: ''}" />
      </div>
      <label class="col-sm-2" for="client_info" class="form-label">Invoice no:</label>
      <div class="col">
        <input class="form-control" name="invoice_no" value="{$invoice_no|default: ''}" />
      </div>
    </div>
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
