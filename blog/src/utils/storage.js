export function getStorage(key) {
    let obj = window.localStorage.getItem(key)
    return  JSON.parse(obj)
  }
  
export function setStorage(key,val) {
    let obj = JSON.stringify(val)
    return window.localStorage.setItem(key, obj)
}

export function removeStorage(key) {
    return window.localStorage.removeItem(key)
}
  