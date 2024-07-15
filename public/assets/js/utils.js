async function post(path, data, spin = true) {
  var headers = new Headers()
  headers.append(`Content-Type`, `application/json`)
  var raw = JSON.stringify(data)
  var requestOptions = {
    method: `POST`,
    headers,
    body: raw,
  }
  return await _post(path, requestOptions, spin)
}

async function _post(path, requestOptions, spin = true) {
  const result = {
    data: null,
    message: null,
    status: true,
    code: 200,
  }
  if (spin) spinner('show')
  const response = await fetch(`/${path}?_=${Date.now()}`, requestOptions)
  try {
    result.code = response.status
    const data = await response.json()
    if (!data || !data.status) {
      const error = (data && data.message) || response.statusText
      result.message = error
      result.status = false
    } else {
      result.status = data.status
    }
    result.message = data.message
    result.data = data.data
  } catch (error) {
    result.message = error
    result.status = false
  }
  if (spin) spinner('hide')
  return result
}

function getFormData(formId) {
  var form = document.getElementById(formId)
  var formData = new FormData(form)
  return formData
}

function getFormObject(formId) {
  var formObj = {}
  var form = document.getElementById(formId)

  var inputs = form.querySelectorAll(`input[name], select[name]`)
  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i]
    formObj[input.name] = input.value
  }
  return formObj
}

function copyToClipboard(text) {
  var input = document.createElement(`textarea`)
  input.innerHTML = text
  document.body.appendChild(input)
  input.select()
  var result = document.execCommand(`copy`)
  document.body.removeChild(input)
  return result
}

const showAlert = {
  success: (message, callback, timer = 0) => {
    return _alert(`success`, message, callback, timer)
  },
  error: (message, callback, timer = 0) => {
    return _alert(`error`, message, callback, timer)
  },
  warning: (message, callback, timer = 0) => {
    return _alert(`warning`, message, callback, timer)
  },
  info: (message, callback, timer = 0) => {
    return _alert(`info`, message, callback, timer)
  },
}

function _alert(icon, title, callback, timer = 0) {
  Swal.fire({
    icon: icon,
    html: title,
    showConfirmButton: !timer,
    confirmButtonText: `OK`,
    timer: timer,
    allowOutsideClick: false,
    didOpen: () => {
      document.addEventListener(`keypress`, check_keypress)
      document.addEventListener(`keyup`, check_keypress)
    },
  }).then((result) => {
    document.removeEventListener(`keypress`, check_keypress)
    document.addEventListener(`keyup`, check_keypress)
    if (typeof callback == `function`) return callback(result)
  })
}
function showConfirm(message, callback) {
  Swal.fire({
    icon: `warning`,
    html: message,
    showCancelButton: true,
    confirmButtonText: `Yes`,
    cancelButtonText: `No`,
    allowOutsideClick: false,
    didOpen: () => {
      document.addEventListener(`keypress`, check_keypress)
      document.addEventListener(`keyup`, check_keypress)
    },
  }).then((result) => {
    document.removeEventListener(`keypress`, check_keypress)
    document.addEventListener(`keyup`, check_keypress)
    if (typeof callback == `function`) return callback(result)
  })
  // if (!_f.isConfirmed) return
}

function showDialog(
  message,
  confirmButtonText = 'Yes',
  cancelButtonText = 'No',
  icon = 'warning',
  callback
) {
  Swal.fire({
    icon,
    html: message,
    showCancelButton: true,
    confirmButtonText,
    cancelButtonText,
    allowOutsideClick: false,
    didOpen: () => {
      document.addEventListener(`keypress`, check_keypress)
      document.addEventListener(`keyup`, check_keypress)
    },
  }).then((result) => {
    document.removeEventListener(`keypress`, check_keypress)
    document.addEventListener(`keyup`, check_keypress)
    if (typeof callback == `function`) return callback(result)
  })
  // if (!_f.isConfirmed) return
}

let check_keypress = function (e) {
  switch (e?.key) {
    case `Enter`:
      Swal?.clickConfirm()
      e?.preventDefault()
      break
    case `Escape`:
      Swal?.clickCancel()
      e?.preventDefault()
      break
  }
}

function open_link(url, _blank = false) {
  if (!url) return
  let anchor = document.createElement(`a`)
  anchor.href = url
  if (_blank) anchor.target = `_blank`
  anchor.click()
}

const numberWithCommas = (number) => {
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
}

const spinner = (action = 'show' | 'hide') => {
  if (action === 'hide') {
    $('#loader-area').css('display', 'none')
  } else {
    $('#loader-area').css('display', 'flex')
  }
}
function random(min = 0, max = 100) {
  min = Math.ceil(min)
  max = Math.floor(max)
  return Math.floor(Math.random() * (max - min + 1) + min)
}

$(document).ready(function () {
  $('.copybtn').click(function (event) {
    var $tempElement = $('<input>')
    $('body').append($tempElement)
    $tempElement.val($(this).closest('.copybtn').find('span').text()).select()
    document.execCommand('Copy')
    $tempElement.remove()
  })
})

function copylink() {
  $('.alertcopy').show()
  setTimeout(function () {
    $('.alertcopy').hide()
  }, 2000)
}
