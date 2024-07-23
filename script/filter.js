function filterTable() {
    const bookingIdInput = document.getElementById('booking_id').value.toLowerCase();
    const customerNameInput = document.getElementById('customer_name').value.toLowerCase();
    const customerEmailInput = document.getElementById('customer_email').value.toLowerCase();
  
    const table = document.getElementById('bookingTable');
    const tr = table.getElementsByTagName('tr');
  
    for (let i = 1; i < tr.length; i++) {
      const tdBookingId = tr[i].getElementsByTagName('td')[0];
      const tdCustomerName = tr[i].getElementsByTagName('td')[2];
      const tdCustomerEmail = tr[i].getElementsByTagName('td')[3];
  
      if (tdBookingId && tdCustomerName && tdCustomerEmail) {
        const bookingIdText = tdBookingId.textContent || tdBookingId.innerText;
        const customerNameText = tdCustomerName.textContent || tdCustomerName.innerText;
        const customerEmailText = tdCustomerEmail.textContent || tdCustomerEmail.innerText;
  
        if (bookingIdText.toLowerCase().indexOf(bookingIdInput) > -1 &&
            customerNameText.toLowerCase().indexOf(customerNameInput) > -1 &&
            customerEmailText.toLowerCase().indexOf(customerEmailInput) > -1) {
          tr[i].style.display = '';
        } else {
          tr[i].style.display = 'none';
        }
      }
    }
  }
  
  function clearFilters() {
    document.getElementById('booking_id').value = '';
    document.getElementById('customer_name').value = '';
    document.getElementById('customer_email').value = '';
  
    filterTable();
  }
  