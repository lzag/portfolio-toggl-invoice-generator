const List = {
  invoiceId: '',
  deleteUrl: '',
  Init: (e) => {
    document.querySelectorAll('.deleteInvoiceLink').forEach( (link) => {
      link.addEventListener('click', (e) => {
        List.ConfirmDelete(e);
      });
    });
    document.getElementById('confirmDeleteButton').addEventListener('click', () => {
      List.Delete(List.invoiceId, List.deleteUrl);
      List.deleteModal.hide();
    });
    window.addEventListener('load', (e) => {
      List.deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    });
  },
  ConfirmDelete: (e) => {
    e.preventDefault();
    List.invoiceId = e.target.attributes.invoiceid.value;
    List.deleteUrl = e.target.attributes.href.value;
    List.deleteModal.show();
  },
  Delete: (invoiceId, url) => {
    const xhr = new XMLHttpRequest;
    xhr.open(
      'GET',
      url
      );
    xhr.send();
    xhr.onload = function(e) {
      const card = document.getElementById('invoicecard' + invoiceId);
      card.parentNode.removeChild(card);
      List.deleteUrl = '';
      List.invoiceId = '';
      alert('Deleted invoice id ' + invoiceId + '.');
    }
  }
};
List.Init();
