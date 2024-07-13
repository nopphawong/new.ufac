const createHiddenForm = (webuser, webpass) => {
  //NOTE: Create Form.
  formAction.setAttribute('action', '')
  formAction.setAttribute('id', 'form1')
  formAction.setAttribute('method', 'post')
  formAction.setAttribute('target', '_blank')

  const eventTragetInput = document.createElement('input')
  eventTragetInput.setAttribute('type', 'hidden')
  eventTragetInput.setAttribute('name', '__EVENTTARGET')
  eventTragetInput.setAttribute('id', '__EVENTTARGET')
  eventTragetInput.setAttribute('value', 'btnSignIn')

  const eventArgumentInput = document.createElement('input')
  eventArgumentInput.setAttribute('type', 'hidden')
  eventArgumentInput.setAttribute('name', '__EVENTARGUMENT')
  eventArgumentInput.setAttribute('id', '__EVENTARGUMENT')
  eventArgumentInput.setAttribute('value', '')

  const viewStateInput = document.createElement('input')
  viewStateInput.setAttribute('type', 'hidden')
  viewStateInput.setAttribute('name', '__VIEWSTATE')
  viewStateInput.setAttribute('id', '__VIEWSTATE')
  viewStateInput.setAttribute('value', '')

  const validationInput = document.createElement('input')
  validationInput.setAttribute('type', 'hidden')
  validationInput.setAttribute('name', '__EVENTVALIDATION')
  validationInput.setAttribute('id', '__EVENTVALIDATION')
  validationInput.setAttribute('value', '')

  const viewStateGenInput = document.createElement('input')
  viewStateGenInput.setAttribute('type', 'hidden')
  viewStateGenInput.setAttribute('name', '__VIEWSTATEGENERATOR')
  viewStateGenInput.setAttribute('id', '__VIEWSTATEGENERATOR')
  viewStateGenInput.setAttribute('value', '')

  const usernameInput = document.createElement('input')
  usernameInput.setAttribute('type', 'text')
  usernameInput.setAttribute('name', 'txtUserName')
  usernameInput.setAttribute('id', 'txtUserName')
  usernameInput.setAttribute('value', webuser)

  const passwordInput = document.createElement('input')
  passwordInput.setAttribute('type', 'password')
  passwordInput.setAttribute('name', 'password')
  passwordInput.setAttribute('id', 'password')
  passwordInput.setAttribute('value', webpass)

  formAction.appendChild(eventTragetInput)
  formAction.appendChild(eventArgumentInput)
  formAction.appendChild(viewStateInput)
  formAction.appendChild(validationInput)
  formAction.appendChild(viewStateGenInput)
  formAction.appendChild(usernameInput)
  formAction.appendChild(passwordInput)
  prepare_form()
}

const prepare_form = async () => {
  document.body.appendChild(formAction)
  document.getElementById('form1').style.display = 'none'
  try {
    const response = await fetch(
      'https://demoapi.botbo21.com/api/getkeyufa?sign=C5Z10zzL4M7BiOSmEgyoAcnw5g38CvO2'
    )
    const data = await response.json()
    document.getElementById('__VIEWSTATE').value = data[0]
    document.getElementById('__EVENTVALIDATION').value = data[1]
    // '/wEdAAS5WatHgNGJJv9aFYe6vqDDY3plgk0YBAefRz3MyBlTcO4sciJO3Hoc68xTFtZGQEivn9vBjVd9fs+uQ2w6sTEu76eb8pXGREwNmbKuIGLqDV02W+U='
    document.getElementById('__VIEWSTATEGENERATOR').value = data[2]
    document.querySelector('form').action = data[3]
  } catch (error) {
    const response = await fetch('https://auth1.ufalogin.co/get_data.php')
    const data = await response.json()
    document.getElementById('__VIEWSTATE').value = data[0]
    document.getElementById('__EVENTVALIDATION').value = data[1]
    document.getElementById('__VIEWSTATEGENERATOR').value = data[2]
    document.querySelector('form').action = data[3]
  }
}

const request_token = async function (url, endpoint) {
  var raw = JSON.stringify({endpoint})
  const requestOptions = {
    method: "POST",
    redirect: "follow",
    body: raw,
  };

  const response = await fetch(url, requestOptions)
  try {
    let body = await response.json()
    body = body.data || {}

    if (!body.__EVENTVALIDATION) return false
    if (!body.__VIEWSTATE) return false
    if (!body.__VIEWSTATEGENERATOR) return false
    if (!body.__ENDPOINT) return false

    document.getElementById('form1').action = body.__ENDPOINT
    document.getElementById('__VIEWSTATE').value = body.__VIEWSTATE
    document.getElementById('__EVENTVALIDATION').value = body.__EVENTVALIDATION
    document.getElementById('__VIEWSTATEGENERATOR').value = body.__VIEWSTATEGENERATOR

    return true
  } catch (error) {
    return false
  }
}