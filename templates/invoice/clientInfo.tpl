  <p><strong>Client information:</strong></p>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="company_name"><strong>Company name</strong></label>
    <div class="col-sm-9">
      <input name="company_name" type="text" value="{$company_name}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="contact_name"><strong>Contact name</strong></label>
    <div class="col-sm-9">
      <input name="contact_name" type="text" value="{$contact_name}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="contact_email"><strong>Contact email</strong></label>
    <div class="col-sm-9">
      <input name="contact_email" type="email" value="{$contact_email}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="company_country"><strong>Company country</strong></label>
    <div class="col-sm-9">
      <input name="company_country" type="text" value="{$company_country}" />
    </div>
  </div>
  {foreach from=$company_address item=$addressline key=$key}
    <div class="form-group row mb-3">
      <label class="col-sm-3" for="company_address{$key+1}"><strong>Address line {$key+1}</strong></label>
      <div class="col-sm-9">
        <input name="company_address{$key+1}" type="text" value="{$addressline}" />
      </div>
    </div>
  {/foreach}
