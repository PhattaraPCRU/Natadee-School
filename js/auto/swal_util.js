async function makeAjaxRequestJson(url, method, requestData) {
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok.');
        }

        return await response.json();
    } catch (error) {
        throw new Error('Error occurred during the AJAX request: ' + error.message);
    }
}

function swal_confirm(title, text, confirmButtonText, cancelButtonText, callback) {
    swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText
    }).then((confirmed) => {
        if (confirmed.value) {
            callback(true);
        }else{
            callback(false);
        }
    });
}

function swal_input(title, text, inputPlaceholder, confirmButtonText, cancelButtonText, callback) {
    swal.fire({
        title: title,
        text: text,
        input: 'text',
        inputPlaceholder: inputPlaceholder,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        inputValidator: (value) => {
            if (!value) {
              return 'You need to write something!'
            }
        }
    }).then((confirmed) => {
        if (confirmed.value) {
            callback(true, confirmed.value);
        }else{
            callback(false, null);
        }
    });
}

function swal_edit(title, text, inputPlaceholder, inputValue, confirmButtonText, cancelButtonText, callback) {
    swal.fire({
        title: title,
        text: text,
        input: 'text',
        inputPlaceholder: inputPlaceholder,
        inputValue: inputValue,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        inputValidator: (value) => {
            if (!value) {
              return 'You need to write something!'
            }
        }
    }).then((confirmed) => {
        if (confirmed.value) {
            callback(true, confirmed.value);
        }else{
            callback(false, null);
        }
    });
}

function swal_alert(title, text, icon, confirmButtonText) {
    swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText
    });
}

function swal_callback(title, text, icon, confirmButtonText, callback) {
    swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText
    }).then((confirmed) => {
        if (confirmed.value) {
            callback(true);
        }else{
            callback(false);
        }
    });
}

// swal_add_instructor
function generateSelectOptions(options) {
    return options.map(option => `<option value="${option.value}">${option.text}</option>`).join('');
}

function swal_add_instructor(departments, positions, callback) {
    swal.fire({
        title: "Add Instructor",
        text: "Please fill in the information below",
        html:
        '<table style="width: 100%;">' +
        '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input1">Name</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input1" class="swal2-input" placeholder="Name" maxlength="50" style="margin-left: 5%;">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +      
        '<label for="swal-input2">Address</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<textarea id="swal-input2" class="swal2-input" placeholder="Address" maxlength="100" style="margin-left: 5%;"></textarea>' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input3">Tel</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input3" class="swal2-input" placeholder="Tel" maxlength="10" style="margin-left: 5%;">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input4">Username</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input4" class="swal2-input" placeholder="Username" maxlength="20" style="margin-left: 5%;">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input5">Password</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input5" class="swal2-input" placeholder="Password" maxlength="20" style="margin-left: 5%;">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input6">Image</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input6" class="swal2-input form-control" type="file" placeholder="Image" accept="image/png, image/jpeg" style="margin-left: 5%;">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input7">Department</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<select id="swal-input7" class="swal2-input" style="margin-left: 5%;">' + generateSelectOptions(departments) + '</select>' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input8">Position</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<select id="swal-input8" class="swal2-input" style="margin-left: 5%;">' + generateSelectOptions(positions) + '</select>' +
        '</td>' + '</tr>' + '</table>',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        cancelButtonText: "Cancel",
        preConfirm: async () => {
            const name = document.getElementById('swal-input1').value;
            const address = document.getElementById('swal-input2').value;
            const tel = document.getElementById('swal-input3').value;
            const username = document.getElementById('swal-input4').value;
            const password = document.getElementById('swal-input5').value;
            const imageFile = document.getElementById('swal-input6').files[0];
            const department = document.getElementById('swal-input7').value;
            const position = document.getElementById('swal-input8').value;
            
            // Check if any required field is empty
            if (!name || !address || !tel || !username || !password || !department || !position) {
                swal.showValidationMessage('Please fill in all required fields.');
                return false;
            }else if (!name.match(/^[a-zA-Z0-9\u0E00-\u0E7F\s]+$/)) {
                swal.showValidationMessage('Name must be alphanumeric.');
                return false;
            }else if (!address.match(/^[a-zA-Z0-9\u0E00-\u0E7F\s!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]+$/)) {
                swal.showValidationMessage('Address must be alphanumeric.');
                return false;
            }else if (!tel.match(/^[a-zA-Z0-9]+$/) || tel.length < 10) {
                swal.showValidationMessage('Tel must be numberic and at lease 10 character.');
                return false;
            }else if (!username.match(/^[a-zA-Z0-9]+$/)) {
                swal.showValidationMessage('Username must be alphanumeric.');
                return false;
            }else if (!password.match(/^[a-zA-Z0-9]+$/)) {
                swal.showValidationMessage('Password must be alphanumeric.');
                return false;
            }

            const requestData = new FormData();
            requestData.append('action', 'check');
            requestData.append('table', 'instructor');
            requestData.append('i_username', username);

            try {
                const response = await fetch('/php/ajax/sql_ajaxV2.php', {
                    method: 'POST',
                    body: requestData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (data.status === 'error') {
                    swal.showValidationMessage('Username is already taken.');
                    return false;
                } else if (data.status === 'success') {
                    const formData = new FormData();
                    formData.append('i_name', document.getElementById('swal-input1').value);
                    formData.append('i_address', document.getElementById('swal-input2').value);
                    formData.append('i_tel', document.getElementById('swal-input3').value);
                    formData.append('i_username', document.getElementById('swal-input4').value);
                    formData.append('i_password', document.getElementById('swal-input5').value);
                    formData.append('i_pic', document.getElementById('swal-input6').files[0]);
                    formData.append('d_id', document.getElementById('swal-input7').value);
                    formData.append('po_id', document.getElementById('swal-input8').value);

                    formData.append('action', 'add');
                    formData.append('table', 'instructor');

                    return formData;
                }
            } catch (error) {
                console.error('Fetch error:', error);
                swal.showValidationMessage('Username is already taken.');
                return false;
            }
        }
    }).then((confirmed) => {
        if (confirmed.value) {
            callback(true, confirmed.value);
        } else {
            callback(false, null);
        }
    });
}

function sawl_edit_instructor(title, text, confirmButtonText, cancelButtonText, departments, positions, i_id, i_name, i_address, i_tel, i_username, i_password, i_pic, d_id, po_id, callback) {
    swal.fire({
        title: title,
        text: text,
        html:
        '<table style="width: 100%;">' +
        '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input1">Name</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input1" class="swal2-input" placeholder="Name" maxlength="50" style="margin-left: 5%;" value="' + i_name + '">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +      
        '<label for="swal-input2">Address</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<textarea id="swal-input2" class="swal2-input" placeholder="Address" maxlength="100" style="margin-left: 5%;">' + i_address + '</textarea>' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input3">Tel</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input3" class="swal2-input" placeholder="Tel" maxlength="10" style="margin-left: 5%;" value="' + i_tel + '">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input4">Username</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input4" class="swal2-input" placeholder="Username" maxlength="20" style="margin-left: 5%;" value="' + i_username + '">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input5">Password</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input5" class="swal2-input" placeholder="Password" maxlength="20" style="margin-left: 5%;" value="' + i_password + '">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input6">Image</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<input id="swal-input6" class="swal2-input form-control" type="file" placeholder="Image" accept="image/png, image/jpeg" style="margin-left: 5%;">' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input7">Department</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<select id="swal-input7" class="swal2-input" style="margin-left: 5%;">' + generateSelectOptions(departments) + '</select>' +
        '</td>' + '</tr>' + '<tr>' + '<td style="width: 20%;">' +
        '<label for="swal-input8">Position</label>' +
        '</td>' + '<td style="width: 80%;">' +
        '<select id="swal-input8" class="swal2-input" style="margin-left: 5%;">' + generateSelectOptions(positions) + '</select>' +
        '</td>' + '</tr>' + '</table>',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        preConfirm: async () => {
            const name = document.getElementById('swal-input1').value;
            const address = document.getElementById('swal-input2').value;
            const tel = document.getElementById('swal-input3').value;
            const username = document.getElementById('swal-input4').value;
            const password = document.getElementById('swal-input5').value;
            const imageFile = document.getElementById('swal-input6').files[0];
            const department = document.getElementById('swal-input7').value;
            const position = document.getElementById('swal-input8').value;
            
            // Check if any required field is empty
            if (!name || !address || !tel || !username || !password || !department || !position) {
                swal.showValidationMessage('Please fill in all required fields.');
                return false;
            }else if (!name.match(/^[a-zA-Z0-9\u0E00-\u0E7F\s]+$/)) {
                swal.showValidationMessage('Name must be alphanumeric.');
                return false;
            }else if (!address.match(/^[a-zA-Z0-9\u0E00-\u0E7F\s!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]+$/)) {
                swal.showValidationMessage('Address must be alphanumeric.');
                return false;
            }else if (!tel.match(/^[a-zA-Z0-9]+$/) || tel.length < 10) {
                swal.showValidationMessage('Tel must be numberic and at lease 10 character.');
                return false;
            }else if (!username.match(/^[a-zA-Z0-9]+$/)) {
                swal.showValidationMessage('Username must be alphanumeric.');
                return false;
            }else if (!password.match(/^[a-zA-Z0-9]+$/)) {
                swal.showValidationMessage('Password must be alphanumeric.');
                return false;
            }

            const requestData = new FormData();
            requestData.append('action', 'check');
            requestData.append('table', 'instructor');
            requestData.append('i_username', username);
            requestData.append('i_id', i_id);

            try {
                const response = await fetch('/php/ajax/sql_ajaxV2.php', {
                    method: 'POST',
                    body: requestData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (data.status === 'error') {
                    swal.showValidationMessage('Username is already taken.');
                    return false;
                }
            } catch (error) {
                console.error('Fetch error:', error);
                swal.showValidationMessage('Username is already taken.');
                return false;
            }

            const formData = new FormData();
            formData.append('i_id', i_id);
            formData.append('i_name', document.getElementById('swal-input1').value);
            formData.append('i_address', document.getElementById('swal-input2').value);
            formData.append('i_tel', document.getElementById('swal-input3').value);
            formData.append('i_username', document.getElementById('swal-input4').value);
            formData.append('i_password', document.getElementById('swal-input5').value);
            formData.append('i_pic', document.getElementById('swal-input6').files[0]);
            formData.append('d_id', document.getElementById('swal-input7').value);
            formData.append('po_id', document.getElementById('swal-input8').value);

            formData.append('action', 'edit');
            formData.append('table', 'instructor');

            return formData;
        }
    }).then((confirmed) => {
        if (confirmed.value) {
            callback(true, confirmed.value);
        } else {
            callback(false, null);
        }
    }
    );
}