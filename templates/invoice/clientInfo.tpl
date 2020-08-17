  <p><strong>Client information:</strong></p>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="company_name"><strong>Company name</strong></label>
    <div class="col-sm-9">
      <input class="form-control" name="company_name" type="text" value="{$company_name}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="contact_name"><strong>Contact name</strong></label>
    <div class="col-sm-9">
      <input class="form-control" name="contact_name" type="text" value="{$contact_name}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="contact_email"><strong>Contact email</strong></label>
    <div class="col-sm-9">
      <input class="form-control" name="contact_email" type="email" value="{$contact_email}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="company_country"><strong>Company country</strong></label>
    <div class="col-sm-9">
      <input class="form-control" name="company_country" type="text" value="{$company_country}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="company_address1"><strong>Address line 1</strong></label>
    <div class="col-sm-9">
      <input class="form-control" name="company_address1" type="text" value="{$company_address[0]|default: ''}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="company_address2"><strong>Address line 2</strong></label>
    <div class="col-sm-9">
      <input class="form-control" name="company_address2" type="text" value="{$company_address[1]|default: ''}" />
    </div>
  </div>
  <div class="form-group row mb-3">
    <label class="col-sm-3" for="company_address3"><strong>Address line 3</strong></label>
    <div class="col-sm-9">
      <input class="form-control" name="company_address3" type="text" value="{$company_address[2]|default: ''}" />
    </div>
  </div>
