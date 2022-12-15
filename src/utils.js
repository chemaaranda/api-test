
  const validJSON = (obj) => {
    let valid = true
    try {
        let _obj = JSON.parse(obj)
    } catch (error) {
      valid = false
    }
    return valid
  }
  
  export { validJSON }; 