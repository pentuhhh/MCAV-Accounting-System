// JavaScript for table interaction

function searchTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("userTable");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2]; // Column index where you want to search (Last Name in this case)
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function sortTableById() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("userTable");
  switching = true;
  
  while (switching) {
    switching = false;
    rows = table.rows;
    
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[0]; // Column index where you want to sort (ID in this case)
      y = rows[i + 1].getElementsByTagName("TD")[0];
      
      if (Number(x.innerHTML) < Number(y.innerHTML)) {
        shouldSwitch = true;
        break;
      }
    }
    
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function showPopup(index) {
  var popupMenus = document.querySelectorAll('.popup-menu');
  popupMenus.forEach(menu => menu.classList.add('hidden'));
  
  var popupMenu = document.querySelector(`#popupMenu${index}`);
  popupMenu.classList.remove('hidden');
}

function showModifyModal(userId) {
  console.log(`Modify user with ID ${userId}`);
  // Add your logic to show a modify modal here
}

function showDetailsModal(userId) {
  console.log(`Show details for user with ID ${userId}`);
  // Add your logic to show a details modal here
}

function deleteRow(userId) {
  console.log(`Delete user with ID ${userId}`);
  // Add your logic to delete the row here
}
