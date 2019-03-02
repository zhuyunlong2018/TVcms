export function getStorage(key) {
  const obj = window.localStorage.getItem(key)
  return JSON.parse(obj)
}

export function setStorage(key, val) {
  const obj = JSON.stringify(val)
  return window.localStorage.setItem(key, obj)
}

export function removeStorage(key) {
  return window.localStorage.removeItem(key)
}

export function getSession(key) {
  const obj = window.sessionStorage.getItem(key)
  return JSON.parse(obj)
}

export function setSession(key, val) {
  const obj = JSON.stringify(val)
  return window.sessionStorage.setItem(key, obj)
}

export function removeSession(key) {
  return window.sessionStorage.removeItem(key)
}
