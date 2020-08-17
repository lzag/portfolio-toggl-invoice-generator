document.querySelectorAll('.deleteInvoiceLink').forEach( (link) => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const invoiceId = e.target.attributes.invoiceid.value;
    const url = e.target.attributes.href.value;
    const xhr = new XMLHttpRequest;
    xhr.open(
      'GET',
      url
      );
    xhr.send();
    xhr.onload = function(e) {
      const card = document.getElementById('invoicecard' + invoiceId);
      card.parentNode.removeChild(card);
      alert('Deleted invoice id ' + invoiceId + '.');
    }
  });
});
