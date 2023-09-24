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
}

async function makeAjaxRequestJson(url, method, data) {
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

async function handleAdd(requestData, target_name) {
    try {
        const table = getTable();

        const url = '/php/ajax/sql_ajaxV2.php';
        const responseData = await makeAjaxRequest(url, 'POST', requestData);

        if (responseData.status === 'success') {
            console.log(responseData.message);
            swal_callback('Added!', `${target_name} has been added.`, 'success', 'OK', () => {
                window.location.reload();
            });
        } else {
            console.error(responseData.message);
            swal.fire('Error!', responseData.message, 'error');
        }
    } catch (error) {
        console.error('Error adding row:', error);
        swal.fire('Error!', `Error adding ${target_name}.`, 'error');
    }
}

async function handleDelete(target_id, target_name) {
    try {
        const table = getTable();

        const url = '/php/ajax/sql_ajaxV2.php';
        const requestData = { action: 'delete', table: table, id: target_id };
        const responseData = await makeAjaxRequestJson(url, 'POST', requestData);

        if (responseData.status === 'success') {
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

        const url = '/php/ajax/sql_ajaxV2.php';
        const requestData = { action: 'edit', table: table, id: target_id, name: target_name, value: target_value };
        const responseData = await makeAjaxRequest(url, 'POST', requestData);

        if (responseData.status === 'success') {
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

// function sawl_edit_instructor(title, text, confirmButtonText, cancelButtonText, departments, positions, i_id, i_name, i_address, i_tel, i_username, i_password, i_pic, d_id, po_id, callback) {
  
function applyEditButtonListener(){
  const editButtons = document.querySelectorAll('.ajax-edit-btn');
  editButtons.forEach((button) => {
      button.addEventListener('click', function () {
        // console.log("edit button clicked");
        const target_id = this.getAttribute('data-id');
        const target_name = document.querySelector(`.id_${target_id}`).querySelector('.name').getAttribute('colname');
        const target_value = document.querySelector(`.id_${target_id}`).querySelector('.name').innerText;
        if (getTable === 'insturctor') {
          // function sawl_edit_instructor(title, text, confirmButtonText, cancelButtonText, departments, positions, i_id, i_name, i_address, i_tel, i_username, i_password, i_pic, d_id, po_id, callback) {
        } else {
          handleEdit(target_id, target_name, target_value);
        }
      });
    });
}


applyDeleteButtonListener();