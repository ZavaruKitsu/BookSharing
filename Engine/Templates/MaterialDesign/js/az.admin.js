function setId(id) {
  document.getElementById('submitId').value = id;
}

function loadDesc(id) {
  let formData = {
    'addon': 'Submit',
    'action': 'loadDesc',
    'id': id,

  };

  $.ajax({
    url: "/api.php",
    type: "POST",
    data: formData,
    success: function (data, textStatus, jqXHR) {
      if (data.code) {
        alertify.success(data.message, 60);
      } else {
        alertify.error(data.message);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alertify.error(jqXHR);
    }
  });
}

function confirmBook(id) {
  let formData = {
    'addon': 'Submit',
    'action': 'confirmBook',
    'id': id,

  };

  ajaxSubmitter(formData, '', false);
}

function declineBook() {
  const reason = document.getElementById('declineReason').value;
  const id = document.getElementById('submitId').value;
  const test = document.getElementById('test').value;

  console.log('Secret: ' + test);

  let formData = {
    'addon': 'Submit',
    'action': 'declineBook',
    'id': id,
    'reason': reason,

  };

  ajaxSubmitter(formData, '', false);
}

function ban(id) {
  let formData = {
    'addon': 'Admin',
    'action': 'ban',
    'id': id,

  };

  ajaxSubmitter(formData, '', true);
}

function unBan(id) {
  const test = document.getElementById('test').value;

  console.log('Secret: ' + test);

  let formData = {
    'addon': 'Admin',
    'action': 'unBan',
    'id': id,

  };

  ajaxSubmitter(formData, '', true);
}

function editBook(id) {
  const name = document.getElementById('bookName').value;
  const author = document.getElementById('bookAuthor').value;
  const desc = document.getElementById('bookDesc').value;
  const owner = parseInt(document.getElementById('bookOwner').value);
  const hidden = document.getElementById('bookHidden').checked;

  let formData = {
    'addon': 'Books',
    'action': 'editBook',
    'id': id,
    'name': name,
    'author': author,
    'desc': desc,
    'owner': owner,
    'hidden': hidden,

  };

  console.log(formData);

  if (document.getElementById('bookImage').files[0] !== undefined)
    setBookImage(id);

  ajaxSubmitter(formData, '', false);
}

function setBookImage(id) {
  const file = document.getElementById('bookImage').files[0];

  console.log(file);

  const formData = new FormData();

  formData.append('addon', 'Books');
  formData.append('action', 'uploadImage');
  formData.append('id', id);
  formData.append('img', file);
  formData.append('secret', test);

  console.log(formData);

  $.ajax({
    url: "/api.php",
    type: "POST",
    dataType: 'json',
    processData: false,
    contentType: false,
    data: formData,
    success: function (data, textStatus, jqXHR) {
      if (data.code)
        alertify.success(data.message);
      else
        alertify.error(data.message);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alertify.error(jqXHR);
    }
  });
}

function addBook() {
  const name = document.getElementById('bookName').value;
  const author = document.getElementById('bookAuthor').value;
  const desc = document.getElementById('bookDesc').value;
  const owner = parseInt(document.getElementById('bookOwner').value);
  const hidden = document.getElementById('bookHidden').checked;

  let formData = {
    'addon': 'Books',
    'action': 'addBook',
    'name': name,
    'author': author,
    'desc': desc,
    'owner': owner,
    'hidden': hidden,

  };

  console.log(formData);

  let id = 0;

  $.ajax({
    url: "/api.php",
    type: "POST",
    data: formData,
    async: false,
    success: function (data, textStatus, jqXHR) {
      if (data.code) {
        alertify.success(data.message);
        id = data.aditInfo;
      } else {
        alertify.error(data.message);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alertify.error('Произошла ошибка на стороне сервера!');
    }
  });

  if (document.getElementById('bookImage').files[0] !== undefined)
    setBookImage(id);

  document.href = '?page=editBook&id=' + id;
}