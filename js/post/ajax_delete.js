// Function to handle AJAX requests
function getTable() {
    const currentURL = window.location.href;
    const match = currentURL.match(/\/([^/]+)\/$/);

    if (!match || match.length < 2) {
        console.error('Table name not found in URL');
        return;
    }

    return match[1];
}

async function makeAjaxRequest(url, method, data) {
    if (getTable() == 'instructor'){
      try {
        const response = await fetch(url, {
          method: method,
          body: data
        });
    
        if (!response.ok) {
          throw new Error('Network response was not ok.');
        }
    
        return await response.json();
      } catch (error) {
        throw new Error('Error occurred during the AJAX request: ' + error.message);
      }
    }else{
      try {
        const response = await fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });
    
        if (!response.ok) {
          throw new Error('Network response was not ok.');
        }
    
        return await response.json();
      } catch (error) {
        throw new Error('Error occurred during the AJAX request: ' + error.message);
      }
    }
  }
  
async function handleDelete(target_id, target_name) {
    try {
        const table = getTable();

        const url = '/php/ajax/sql_ajax.php';
        const requestData = { action: 'delete', table: table, id: target_id };
        const responseData = await makeAjaxRequest(url, 'POST', requestData);

        // Handle the response
        if (responseData.status === 'success') {
            // Delete the row from the table on success
            document.querySelector(`.id_${target_id}`).remove();
            swal.fire('Deleted!', `${target_name} has been deleted.`, 'success');
            console.log(responseData.message);
        } else {
            console.error(responseData.message);
        }
    } catch (error) {
        console.error('Error deleting row:', error);
        swal.fire('Error!', `Error deleting ${target_name}.`, 'error');
    }
}

async function handleEdit(target_id, target_name, target_value) {
    try {
        const table = getTable();

        const url = '/php/ajax/sql_ajax.php';
        const requestData = { action: 'edit', table: table, id: target_id, name: target_name, value: target_value };
        const responseData = await makeAjaxRequest(url, 'POST', requestData);

        // Handle the response
        if (responseData.status === 'success') {
            // Delete the row from the table on success
            document.querySelector(`.id_${target_id}`).querySelector('.name').innerText = target_value;
            swal.fire('Edited!', `${target_value} has been edited.`, 'success');
            console.log(responseData.message);
        } else {
            console.error(responseData.message);
        }
    } catch (error) {
        console.error('Error editing row:', error);
        swal.fire('Error!', `Error editing ${target_name}.`, 'error');
    }
}

async function handleAdd(target_name, target_value) {
    try {
        const table = getTable();

        const url = '/php/ajax/sql_ajax.php';
        const requestData = { action: 'add', table: table, name: target_name, value: target_value };
        const responseData = await makeAjaxRequest(url, 'POST', requestData);

        // Handle the response
        if (responseData.status === 'success') {
          addRow(table, target_name, responseData.id, target_value);
          console.log(responseData.message);
      } else {
          console.error(responseData.message);
      }             
    } catch (error) {
        console.error('Error adding row:', error);
        swal.fire('Error!', `Error adding ${target_name}.`, 'error');
    }
}
  
  // Add event listeners to all delete buttons with class "ajax-delete-btn"
function applyDeleteButtonListener(){
  const deleteButtons = document.querySelectorAll('.ajax-delete-btn');
  deleteButtons.forEach((button) => {
      button.addEventListener('click', function () {
        // console.log("delete button clicked");
        const target_id = this.getAttribute('data-id');
        const target_name = document.querySelector(`.id_${target_id}`).querySelector('.name').innerText;
        swal_confirm('Are you sure?', `You are about to delete ${target_name}.`, 'Yes, delete it!', 'No, cancel!', (confirmed) => {
          if (confirmed) {
            handleDelete(target_id, target_name);
          } else {
            swal.fire('Cancelled', `${target_name} is safe.`, 'error');
          }
        });
      });
    });
}
  
function applyEditButtonListener(){
  const editButtons = document.querySelectorAll('.ajax-edit-btn');
  editButtons.forEach((button) => {
      button.addEventListener('click', function () {
        // console.log("edit button clicked");
        const target_id = this.getAttribute('data-id');
        const target_name = document.querySelector(`.id_${target_id}`).querySelector('.name').getAttribute('colname');
        const target_value = document.querySelector(`.id_${target_id}`).querySelector('.name').innerText;
        swal_edit('Edit', `Edit ${target_value}.`, 'New name', target_value, 'Save', 'Cancel', (confirmed, value) => {
          if (confirmed) {
            handleEdit(target_id, target_name, value);
          }
        });
      });
    });
}

function applyAddButtonListener(){
  const addButtons = document.querySelectorAll('.ajax-add-btn');
  addButtons.forEach((button) => {
      button.addEventListener('click', function () {
        // console.log("add button clicked");
        const target_name = this.getAttribute('colname');
        const table = getTable();
        
        swal_input('Add', `Add ${table}.`, `New ${table}`, 'Save', 'Cancel', (confirmed, value) => {
          if (confirmed) {
            handleAdd(target_name, value);
          }
        });
      });
    });
}


// Add Row Function
function addRow(table, colname, id, value){
  if (table == 'department'){
    var table = document.getElementById("table_content");
    var row = table.insertRow(-1);
    row.classList.add(`id_${id}`);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2); 
    var cell4 = row.insertCell(3);
    cell2.classList.add("name");
    cell2.setAttribute("colname", colname);
    cell4.setAttribute("colspan", "2");
    cell4.setAttribute("align", "center");
    cell1.innerHTML = id;
    cell2.innerHTML = value;
    cell3.innerHTML = "No Head of Department";
    cell4.innerHTML = '<button class="btn btn-orange me-1 ajax-edit-btn-new" data-id="'+id+'">Edit</button><button class="btn btn-delete ajax-delete-btn-new" data-id="'+id+'">Delete</button>';
  }else if (table == 'position'){
    var table = document.getElementById("table_content");
    var row = table.insertRow(-1);
    row.classList.add(`id_${id}`);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2); 
    cell2.classList.add("name");
    cell2.setAttribute("colname", colname);
    cell3.setAttribute("colspan", "2");
    cell3.setAttribute("align", "center");
    cell1.innerHTML = id;
    cell2.innerHTML = value;
    cell3.innerHTML = '<button class="btn btn-orange me-1 ajax-edit-btn-new" data-id="'+id+'">Edit</button><button class="btn btn-delete ajax-delete-btn-new" data-id="'+id+'">Delete</button>';
  }

  const deleteButtons = document.querySelectorAll('.ajax-delete-btn-new');
  deleteButtons.forEach((button) => {
      button.addEventListener('click', function () {
        // console.log("delete button clicked");
        const target_id = this.getAttribute('data-id');
        const target_name = document.querySelector(`.id_${target_id}`).querySelector('.name').innerText;
        swal_confirm('Are you sure?', `You are about to delete ${target_name}.`, 'Yes, delete it!', 'No, cancel!', (confirmed) => {
          if (confirmed) {
            handleDelete(target_id, target_name);
          } else {
            swal.fire('Cancelled', `${target_name} is safe.`, 'error');
          }
        });
      });
    });
  const editButtons = document.querySelectorAll('.ajax-edit-btn-new');
  editButtons.forEach((button) => {
      button.addEventListener('click', function () {
        // console.log("edit button clicked");
        const target_id = this.getAttribute('data-id');
        const target_name = document.querySelector(`.id_${target_id}`).querySelector('.name').getAttribute('colname');
        const target_value = document.querySelector(`.id_${target_id}`).querySelector('.name').innerText;
        swal_edit('Edit', `Edit ${target_value}.`, 'New name', target_value, 'Save', 'Cancel', (confirmed, value) => {
          if (confirmed) {
            handleEdit(target_id, target_name, value);
          }
        });
      });
    });
  swal.fire('Added!', `${value} has been added.`, 'success');
}

applyAddButtonListener();
applyDeleteButtonListener();
applyEditButtonListener();