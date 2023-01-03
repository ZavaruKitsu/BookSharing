// Submit registration form
function validateRegForm() {
  const login = document.getElementById('regLogin').value;
  if (login === "") {
    alertify.error('Поле \'логин\' должно быть заполнено!');
    return false;
  }
  const email = document.getElementById('regEmail').value;
  if (email === "") {
    alertify.error('Поле \'почта\' должно быть заполнено!');
    return false;
  } else {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(email)) {
      alertify.error('Поле \'почта\' заполнено неправильно!');
      return false;
    }
  }
  const first = document.getElementById('regFirst').value;
  const last = document.getElementById('regLast').value;
  if (first === "") {
    alertify.error('Поле \'имя\' должно быть заполнено!');
    return false;
  }
  if (last === "") {
    alertify.error('Поле \'фамилия\' должно быть заполнено!');
    return false;
  }

  if (first.length < 4 || first.length > 20) {
    alertify.error('Поле \'имя\' заполнено неправильно!');
    return false;
  }
  if (last.length < 4 || last.length > 32) {
    alertify.error('Поле \'фамилия\' заполнено неправильно!');
    return false;
  }

  const password1 = document.getElementById('regPassword').value;
  const password2 = document.getElementById('regPassword2').value;
  if (password1 === "" || password2 === "") {
    alertify.error('Поле \'пароль\' должно быть заполнено!');
    return false;
  }

  if (password1 !== password2) {
    alertify.error('Поля \'пароль\' не совпадают!');
    return false;
  }

  if (password1.length < 7) {
    alertify.error('Поле \'пароль\' заполнено неправильно. Пароль должен содержать хотя бы 8 символов!');
    return false;
  }

  const captcha = document.getElementById('regCaptcha').value;
  console.log(captcha);
  if (captcha === "") {
    alertify.error('Пройдите капчу!');
    return false;
  }


  alertify.message('Отправка формы...');
  let formData = {
    'addon': 'Auth',
    'action': 'reg',
    'first': first,
    'last': last,
    'login': login,
    'email': email,
    'password': password1,
    'captcha': captcha,

  };


  ajaxSubmitter(formData, '', true);
  grecaptcha.reset(1);
}


// Submit authorization form
function validateAuthForm() {
  const login = document.getElementById('authLogin').value;
  if (login === "") {
    alertify.error('Поле \'логин\' должно быть заполнено!');
    return false;
  }

  const password = document.getElementById('authPassword').value;
  if (password === "") {
    alertify.error('Поле \'пароль\' должно быть заполнено!');
    return false;
  }

  const captcha = document.getElementById('authCaptcha').value;
  console.log(captcha);
  if (captcha === "") {
    alertify.error('Пройдите капчу!');
    return false;
  }


  alertify.message('Отправка формы...');
  let formData = {
    'addon': 'Auth',
    'action': 'auth',
    'login': login,
    'password': password,
    'captcha': captcha,

  };


  ajaxSubmitter(formData, '', true);
  grecaptcha.reset(0);
}


// Get out of queue
function cancelQueue(id) {
  let formData = {
    'addon': 'Transfer',
    'action': 'cancelQueue',
    'bookId': id,

  };


  ajaxSubmitter(formData, '', true);
}


// Get in queue
function queueTransfer(bookId) {
  let formData = {
    'addon': 'Transfer',
    'action': 'queueTransfer',
    'bookId': bookId,

  };


  ajaxSubmitter(formData, '', true);
}

// Submit new book
function submitBook() {
  const name = document.getElementById('submitName').value;
  const author = document.getElementById('submitAuthor').value;
  const desc = document.getElementById('submitDesc').value;

  if (name === '') {
    alertify.error('Поле \'название\' должно быть заполнено!');
    return false;
  }
  if (author === '') {
    alertify.error('Поле \'автор\' должно быть заполнено!');
    return false;
  }


  let formData = {
    'addon': 'Submit',
    'action': 'submit',
    'name': name,
    'author': author,
    'desc': desc,

  };


  ajaxSubmitter(formData, '', true);
}


// Create book transfer request
function transferBook() {
  const distId = document.getElementById('usernameDist').value;
  const rating = parseInt(document.getElementById('rating').value);
  const bookId = document.getElementById('bookId').value;

  if (distId === '') {
    alertify.error('Поле \'имя пользователя\' должно быть заполнено!');
    return false;
  }

  if (rating < 0 || rating > 5) {
    alertify.error('Поле \'оценка\' заполнено неправильно!');
    return false;
  }

  alertify.message('Отправка формы...');
  let formData = {
    'addon': 'Transfer',
    'action': 'createTransfer',
    'bookId': bookId,
    'distId': distId,
    'rating': rating,

  };


  ajaxSubmitter(formData, '', true);
}


// Accept book transfer
function transferAccept(transferId) {
  const state = document.getElementById('state').value;

  alertify.message('Отправка формы...');
  let formData = {
    'addon': 'Transfer',
    'action': 'acceptTransfer',
    'state': state,
    'transferId': transferId,

  };

  ajaxSubmitter(formData, '?page=profile');
}


// Cancel book transfer
function transferCancel(transferId) {
  alertify.message('Отправка формы...');
  let formData = {
    'addon': 'Transfer',
    'action': 'cancelTransfer',
    'transferId': transferId,

  };

  ajaxSubmitter(formData, '?page=profile');
}


// Change contacts
function changeContacts(oldTelegram, oldVk) {
  const telegram = document.getElementById('telegramUsername').value;
  const vk = document.getElementById('vkUrl').value;

  if (telegram === oldTelegram && vk === oldVk) {
    alertify.error('Вы ничего не изменили!');
    return false;
  }

  alertify.message('Отправка формы...');

  if (telegram !== oldTelegram) {
    let formData = {
      'addon': 'Contacts',
      'action': 'changeTelegram',
      'telegram': telegram,

    };
    ajaxSubmitter(formData);
  }
  if (vk !== oldVk) {
    let formData = {
      'addon': 'Contacts',
      'action': 'changeVk',
      'vk': vk,

    };
    ajaxSubmitter(formData);
  }
}

function hideSubmit(id) {
  alertify.message('Отправка формы...');
  let formData = {
    'addon': 'Submit',
    'action': 'hideSubmit',
    'id': id,

  };

  ajaxSubmitter(formData);
}


// Ajax function
function ajaxSubmitter(formData, redirect = '', reload = false) {
  $.ajax({
    url: "/api.php",
    type: "POST",
    data: formData,
    success: function (data, textStatus, jqXHR) {
      if (data.code) {
        alertify.success(data.message);
        if (redirect !== '' && !reload) {
          setTimeout(function () {
            location.href = redirect
          }, 1000);
        } else if (reload) {
          setTimeout(function () {
            location.reload()
          }, 1000);
        }
      } else {
        alertify.error(data.message);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alertify.error('Произошла ошибка на стороне сервера!');
    }
  });
}

// Kostil' for contract page
function setState(state) {
  document.getElementById('state').value = state;
}


// Kostil' for profile->transfer window
function setBookId(id) {
  document.getElementById('bookId').value = id;
}

// Handler for 'Search by ID'
function goToId(ele) {
  if (event.key === 'Enter') {
    const id = document.getElementById('searchId').value;
    document.location.href = '?book=' + id;
  }
}


// reCaptcha callback functions
function onRegHuman(response) {
  document.getElementById('regCaptcha').value = response;
}

function onAuthHuman(response) {
  document.getElementById('authCaptcha').value = response;
}