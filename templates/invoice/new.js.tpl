<script type="text/javascript">
  document.getElementById('getInvoiceData').addEventListener('click', (e) => {
    let xhr = new XMLHttpRequest();
    let servicesDiv = document.getElementById('services');
    let fromDate =  document.getElementById('fromDate').value;
    let toDate =  document.getElementById('toDate').value;
    let client =  document.getElementById('client').value;

      document.getElementById('services').innerHTML = xhr.responseText;
      document.getElementById('services').innerHTML = xhr.responseText;
    xhr.open(
      'GET',
      '{BASE_URL}/invoice/fetchServices/' + fromDate + '/' + toDate + '/' + client
      );
    xhr.send();
    xhr.onload = function() {
      document.getElementById('services').innerHTML = xhr.responseText;
    }
    e.preventDefault();
  });
</script>
