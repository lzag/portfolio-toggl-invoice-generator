<script type="text/javascript">

let Invoice = {
  init: function() {
    document.getElementById('getInvoiceData').addEventListener('click', (e) => {
      Invoice.getServices();
      Invoice.getPersonalInfo();
      Invoice.getClientData();
      Invoice.getBankData();
      document.getElementById('generateInvoice').removeAttribute('disabled');
      e.preventDefault();
    });

    document.getElementById('generateInvoice').addEventListener('click', (e) => {
      Invoice.createInvoice();
      e.preventDefault();
    });
  },
  getServices: function() {
    let xhr = new XMLHttpRequest();
    let servicesDiv = document.getElementById('services');
    let fromDate =  document.getElementById('fromDate').value;
    let toDate =  document.getElementById('toDate').value;
    let client =  document.getElementById('client').value;

    document.getElementById('services').innerHTML = xhr.responseText;
    xhr.open(
      'GET',
      '{BASE_URL}/invoice/fetchServices/' + fromDate + '/' + toDate + '/' + client
      );
    xhr.send();
    xhr.onload = function() {
      document.getElementById('services').innerHTML = xhr.responseText;
    }
  },
  getPersonalInfo: function() {
    let client =  document.getElementById('client').value;
    let xhr = new XMLHttpRequest();
    xhr.open(
      'GET',
      '{BASE_URL}/invoice/fetchClientData/' + client
      );
    xhr.send();
    xhr.onload = function() {
      document.getElementById('client_info').innerHTML = xhr.responseText;
    }
  },
  getClientData: function() {
    let xhr = new XMLHttpRequest();
    xhr.open(
      'GET',
      '{BASE_URL}/invoice/fetchMyData/'
      );
    xhr.send();
    xhr.onload = function() {
      document.getElementById('my_info').innerHTML = xhr.responseText;
    }
  },
  getBankData: function() {
    let xhr = new XMLHttpRequest();
    xhr.open(
      'GET',
      '{BASE_URL}/invoice/fetchBankData/'
      );
    xhr.send();
    xhr.onload = function() {
      document.getElementById('bank_info').innerHTML = xhr.responseText;
    }
  },
  createInvoice: function() {
    const xhr = new XMLHttpRequest();
    const form = document.forms.invoiceForm; 
    const invoiceData = new FormData(form);
    let postData = [];
    for (const val of invoiceData) {
        const data = {};
        data[val[0]] = val[1];
        postData.push(data);
    } 
    let my_name = invoiceData.entries();
    postData = JSON.stringify(postData);
    xhr.open(
      'POST',
      '{BASE_URL}/invoice/createFromForm/'
      );
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(postData);
    xhr.onload = function() {
      document.getElementById('bank_info').innerHTML = xhr.responseText;
    }
  }
}
Invoice.init();
</script>
