{include file="{$header}"}

<div class="container">
  <form class="row g-3" action="#">
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
    <div id="services" class="col-md-12">
    </div>
    <div class="col-md-3">
      <button id="getInvoiceData" class="btn btn-primary">Get Services</button> 
    </div>
  </form>

</div>

  my information

Invoice_date
Due_date

Bill to:


Contact:

Rate:

Services:


Subtotal:

Tax Total:

Total:

Bank Data:

{include file="{PROJECT_DIR}/templates/invoice/new.js.tpl"}
{include file="{$footer}"}
